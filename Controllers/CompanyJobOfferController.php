<?php
namespace Controllers;

use Services\JobOfferService;
use Repositories\CompanyRepository;   
use Repositories\CareerRepository;
use Repositories\JobOfferRepository;
use Repositories\JobPositionRepository;  
use DAO\NotificationDAO as NotificationDAO;
use DAO\StudentPreferenceDAO;
use DAO\ApplicationDAO;
use DAO\InterviewDAO;
use Models\JobOffer;
use Utils\Utils;
use Exception;
use Utils\MailService as MailService;

class CompanyJobOfferController
{
    private CompanyRepository $companyRepo;
    private CareerRepository $careerRepo;
    private JobOfferRepository $jobOfferRepo;
    private JobPositionRepository $jobPositionRepo;  
    private StudentPreferenceDAO $studentPreferenceDAO;
    private NotificationDAO $notificationDAO;
    private ApplicationDAO $applicationDAO;
    private InterviewDAO $interviewDAO;

    public function __construct()
    {
        Utils::checkCompanySession();
        $this->jobOfferRepo = new JobOfferRepository();
        $this->jobPositionRepo = new JobPositionRepository();
        $this->companyRepo = new CompanyRepository();
        $this->careerRepo = new CareerRepository();
        $this->studentPreferenceDAO = new StudentPreferenceDAO();
        $this->notificationDAO = new NotificationDAO();
        $this->applicationDAO = new ApplicationDAO();
        $this->interviewDAO = new InterviewDAO();
    }

    /**
     * Listar las ofertas de la empresa logueada
     */
    public function listMyOffers()
    {
        try {
            $user = $_SESSION['loggedUser'];
            $company = $this->companyRepo->getByUserId($user->getUserId());
            
            $jobOffers = $this->jobOfferRepo->getByCompanyId($company->getCompanyId());
            
            foreach($jobOffers as $offer) {
                // Usamos el ApplicationDAO para contar
                $count = $this->applicationDAO->countApplicantsByOffer($offer->getJobOfferId());
                $offer->setApplicantCount($count);
            }
            // Traemos todas las carreras para el mapeo de nombres
            $careers = $this->careerRepo->getAll();
            $careerMap = [];
            foreach ($careers as $career) {
                $careerMap[$career->getCareerId()] = $career->getDescription();
            }

            // Traemos todos los puestos para saber a qué carrera pertenece cada uno
            $positions = $this->jobPositionRepo->getAll(); 
            $positionToCareerMap = [];
            foreach ($positions as $pos) {
                $positionToCareerMap[$pos->getJobPositionId()] = $pos->getCareerId();
            }

            require_once(COMPANY_VIEWS . "company-joboffer-list.php");
        } catch (Exception $ex) {
            $message = $ex->getMessage();
            require_once(COMPANY_VIEWS . "company-menu.php");
        }
    }

    /**
     * Mostrar formulario de agregar
     */
    public function showAddView()
    {
        $careers = $this->careerRepo->getAll();

        $jobPositions = $this->jobPositionRepo->getAll();
        
        require_once(COMPANY_VIEWS . "company-joboffer-add.php");
    }

    /**
     * Procesar el alta de una oferta
     */
    public function add($request)
    {
        try {
            // 1. Validar sesión
            if (!isset($_SESSION['loggedUser'])) {
                throw new Exception("Debe iniciar sesión para publicar una oferta.");
            }

            $user = $_SESSION['loggedUser'];
            $company = $this->companyRepo->getByUserId($user->getUserId());

            if (!$company) {
                throw new Exception("No se encontró la empresa asociada a este usuario.");
            }

            $startDate = $request["startDate"];
            $deadline = $request["deadline"];

            if (strtotime($deadline) < strtotime($startDate)) {
                throw new Exception("La fecha de cierre (deadline) no puede ser anterior a la fecha de inicio.");
            }

            // (Opcional) Validar que el deadline no sea en el pasado
            if (strtotime($deadline) < strtotime(date('Y-m-d'))) {
                throw new Exception("La fecha de cierre no puede ser una fecha pasada.");
            }

            // 2. Crear y popular el modelo
            $jobOffer = new JobOffer();
            $jobOffer->setCompanyId($company->getCompanyId())
                    ->setTitle($request["title"]) // Extraemos directamente del array
                    ->setDescription($request["description"])
                    ->setSalary($request["salary"])
                    ->setStartDate($request["startDate"])
                    ->setDeadline($request["deadline"])
                    ->setJobPositionId($request["jobPositionId"])
                    ->setActive(true);
                    
            $flyerPath = null;
                if (isset($_FILES['flyer']) && $_FILES['flyer']['error'] === UPLOAD_ERR_OK) {
                    
                    $uploadDir = 'uploads/job-offers/';
                    
                    // Validar que sea realmente una imagen (seguridad)
                    $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
                    $mimeType = finfo_file($fileInfo, $_FILES['flyer']['tmp_name']);
                    $allowedTypes = ['image/jpeg', 'image/png'];

                    if (in_array($mimeType, $allowedTypes)) {
                        // Generar un nombre único para evitar sobreescritura
                        $extension = ($mimeType == 'image/jpeg') ? '.jpg' : '.png';
                        $fileName = 'flyer_' . uniqid() . $extension;
                        $targetPath = $uploadDir . $fileName;

                        // Mover el archivo del temporal al destino final
                        if (move_uploaded_file($_FILES['flyer']['tmp_name'], $targetPath)) {
                            $flyerPath = $fileName;
                        }
                    } else {
                        throw new Exception("Invalid file type. Only JPG or PNG allowed.");
                    }
                }

                // Guardamos el nombre del archivo en el objeto
                $jobOffer->setFlyerImagePath($flyerPath);

            // 3. Persistir
            $newId = $this->jobOfferRepo->add($jobOffer);

            if($newId > 0) {
                // 2. Le ponemos el ID al objeto
                $jobOffer->setJobOfferId($newId);
                
                // 3. Notificamos una sola vez con los datos completos
                $this->notifyInterestedStudents($jobOffer);
                
                $message = "Oferta publicada con éxito.";
            }
            
            // Redirección exitosa
            header("Location: " . FRONT_ROOT . "CompanyJobOffer/listMyOffers");
            exit();

        } catch (Exception $ex) {
            // 4. Manejo de errores: Capturamos el problema y enviamos el mensaje a la vista
            $errorMessage = $ex->getMessage();
            
            // Recargamos los datos necesarios para que el formulario siga siendo funcional
            $careers = $this->careerRepo->getAll(); 
            $jobPositions = $this->jobPositionRepo->getAll(); 
            
            // Requerimos la vista pasando el mensaje de error
            require_once(COMPANY_VIEWS . "company-joboffer-add.php");
        }
    }

    /**
     * Ver postulantes de una oferta específica
     */
    public function viewApplicants($jobOfferId)
    {
        try {
            $jobOffer = $this->jobOfferRepo->getById($jobOfferId);
            
            $applicants = $this->jobOfferRepo->getApplicantsByOffer($jobOfferId);

            require_once(COMPANY_VIEWS . "joboffer-applicants.php");
        } catch (Exception $ex) {
            $message = $ex->getMessage();
            $this->listMyOffers();
        }
    }

    /**
     * Baja lógica de una oferta
     */
    public function delete($jobOfferId)
    {
        try {
            $this->jobOfferRepo->deleteOffer($jobOfferId);
            header("Location: " . FRONT_ROOT . "CompanyJobOffer/listMyOffers");
        } catch (Exception $ex) {
            $message = $ex->getMessage();
            $this->listMyOffers();
        }
    }

    public function viewDetails($jobOfferId)
    {
        try {
            // 1. Obtenemos la oferta específica
            $jobOffer = $this->jobOfferRepo->getById($jobOfferId);

            if (!$jobOffer) {
                throw new Exception("Job Offer not found.");
            }

            // 2. Necesitamos la data de la carrera y el puesto para mostrar nombres, no IDs
            $careers = $this->careerRepo->getAll();
            $careerMap = [];
            foreach ($careers as $career) {
                $careerMap[$career->getCareerId()] = $career->getDescription();
            }

            $positions = $this->jobPositionRepo->getAll(); 
            $positionMap = [];
            $positionToCareerMap = [];
            foreach ($positions as $pos) {
                $positionMap[$pos->getJobPositionId()] = $pos->getDescription();
                $positionToCareerMap[$pos->getJobPositionId()] = $pos->getCareerId();
            }

            require_once(COMPANY_VIEWS . "company-joboffer-detail.php");
        } catch (Exception $ex) {
            $message = $ex->getMessage();
            $this->listMyOffers();
        }
    }

    public function reactive($jobOfferId)
    {
        try {
            $this->jobOfferRepo->updateActiveStatus($jobOfferId, true);
            
            header("Location: " . FRONT_ROOT . "CompanyJobOffer/listMyOffers");
        } catch (Exception $ex) {
            $message = $ex->getMessage();
            $this->listMyOffers();
        }
    }

    /**
 * Muestra el formulario con los datos de la oferta a editar
 */
    public function showEditForm($jobOfferId)
    {
        try {
            $jobOffer = $this->jobOfferRepo->getById($jobOfferId);
            
            if (!$jobOffer) {
                throw new Exception("No se encontró la oferta.");
            }

            // Cargamos los datos para los selectores
            $careers = $this->careerRepo->getAll();
            $jobPositions = $this->jobPositionRepo->getAll();

            require_once(COMPANY_VIEWS . "company-joboffer-edit.php");
        } catch (Exception $ex) {
            $message = $ex->getMessage();
            $this->listMyOffers();
        }
    }

    /**
     * Procesa la actualización
     */
    public function edit($request)
    {
        try {
            // 1. PRIMERO: Traemos la oferta completa de la DB
            $jobOffer = $this->jobOfferRepo->getById($request["jobOfferId"]);

            if (!$jobOffer) {
                throw new Exception("No se encontró la oferta para editar.");
            }

            // 2. AHORA: Actualizamos solo los campos que vienen del formulario
            $jobOffer->setTitle($request["title"]);
            $jobOffer->setDescription($request["description"]);
            $jobOffer->setSalary($request["salary"]);
            $jobOffer->setStartDate($request["startDate"]);
            $jobOffer->setDeadline($request["deadline"]);
            $jobOffer->setJobPositionId($request["jobPositionId"]);

            // 3. Persistimos el objeto completo
            $this->jobOfferRepo->update($jobOffer);
            
            header("Location: " . FRONT_ROOT . "CompanyJobOffer/listMyOffers");
            exit();
        } catch (Exception $ex) {
            $errorMessage = $ex->getMessage();
            $this->showEditForm($request["jobOfferId"]);
        }
    }

    public function showApplicants($jobOfferId, $message = "", $messageType = "info")
    {
        try {
            $jobOffer = $this->jobOfferRepo->getById($jobOfferId);
            
            $applicantList = $this->applicationDAO->getApplicantsByOffer($jobOfferId);

            require_once(COMPANY_VIEWS . "job-offer-applicants.php");
            
        } catch (Exception $ex) {
            echo "Error al cargar aplicantes: " . $ex->getMessage();
        }
    }

    private function notifyInterestedStudents($jobOffer) {
    // 1. Buscamos qué alumnos están interesados en esta categoría (JobPosition)
        $interestedStudents = $this->studentPreferenceDAO->getStudentIdsByPosition($jobOffer->getJobPositionId());
        if(!empty($interestedStudents)) {
            $message = "¡Nueva oportunidad! Se publicó la oferta: " . $jobOffer->getTitle();
            
            foreach($interestedStudents as $row) {
                // 2. Creamos la notificación para cada alumno
                $this->notificationDAO->create($row['studentId'], $jobOffer->getJobOfferId(), $message);
            }
        }
    }

    public function setInterviewStatus() 
    {
        try {
            if($_POST) {
                $studentId = $_POST['studentId'];
                $jobOfferId = $_POST['jobOfferId'];
                $dateTime = $_POST['date_time'];
                $location = $_POST['location'];

                $dateTime = $_POST['date_time'];
                $now = date('Y-m-d H:i:s');

                // Comparamos los strings de fecha (o convertirlos a timestamp)
                if(strtotime($dateTime) < strtotime($now)) {
                    // Si la fecha elegida es menor a ahora, mandamos error y volvemos
                    $this->showApplicants($_POST['jobOfferId'], "No podés programar una entrevista para el pasado.", "danger");
                    return;
                }
                
                // 1. Persistencia
                $this->applicationDAO->updateStatus($studentId, $jobOfferId, 'interview');

                $this->interviewDAO->add($studentId, $jobOfferId, $dateTime, $location);
                
                // 2. Obtención de datos
                $applicant = $this->applicationDAO->getSpecificApplicant($studentId, $jobOfferId);
                $jobOffer = $this->jobOfferRepo->getById($jobOfferId);

                // 3. Notificación
                if ($applicant && $jobOffer) {
                    $this->sendInterviewEmail($applicant, $jobOffer, $dateTime, $location);
                }

                // 4. Feedback al usuario
                $this->showApplicants($jobOfferId, "Estado actualizado a 'Entrevista'.", "success");
            }
        } catch (Exception $ex) {
            $this->showApplicants($jobOfferId, "Error: " . $ex->getMessage(), "danger");
        }
    }

    private function sendInterviewEmail($userData, $jobOffer, $dateTime, $location) 
    {
        $subject = "Invitación a Entrevista: " . $jobOffer->getTitle();
        $fechaFormateada = date('d/m/Y H:i', strtotime($dateTime));
        
        $message = "
            <div style='font-family: Arial; border: 1px solid #eee; padding: 20px;'>
                <h2 style='color: #28a745;'>¡Hola " . $userData['firstName'] . "!</h2>
                <p>La empresa ha revisado tu perfil para el puesto de <strong>" . $jobOffer->getTitle() . "</strong> y quiere entrevistarte.</p>
                <hr>
                <p><strong>📅 Fecha y Hora:</strong> " . $fechaFormateada . " hs</p>
                <p><strong>📍 Lugar/Link:</strong> <a href='" . $location . "'>" . $location . "</a></p>
                <hr>
                <p>Por favor, confirma tu asistencia respondiendo a este correo.</p>
            </div>";

        MailService::send($userData['email'], $subject, $message);
    }

    public function showInterviews() {
        try {
            $user = $_SESSION['loggedUser'];
            $company = $this->companyRepo->getByUserId($user->getUserId());
            
            $interviewList = $this->interviewDAO->getInterviewsByCompany($company->getCompanyId());

            require_once(COMPANY_VIEWS . "company-interviews.php");
        } catch (Exception $ex) {
            $this->listMyOffers();
        }
    }

    public function changeInterviewStatus($interviewId, $newStatus) {
        try {
            $interview = $this->interviewDAO->getById($interviewId); 
            if (!$interview) throw new Exception("Entrevista no encontrada.");

            $studentId = $interview->getStudentId();
            $jobOfferId = $interview->getJobOfferId();

            // 1. Actualizamos SOLAMENTE esta entrevista en la BD
            $this->interviewDAO->updateStatus($interviewId, $newStatus);

            if($newStatus === 'completed') {
                // Aquí sí usamos student y jobOffer porque la POSTULACIÓN es una sola
                $this->applicationDAO->updateStatus($studentId, $jobOfferId, 'completed'); 
            } elseif($newStatus === 'cancelled') {
                $this->applicationDAO->updateStatus($studentId, $jobOfferId, 'active');
                
                $applicant = $this->applicationDAO->getSpecificApplicant($studentId, $jobOfferId);
                $jobOffer = $this->jobOfferRepo->getById($jobOfferId);
                $this->sendCancellationEmail($applicant, $jobOffer);
            }

            $this->showInterviews();
            
        } catch (Exception $ex) {
            $this->showInterviews();
        }
    }

    private function sendCancellationEmail($userData, $jobOffer) {
        $subject = "Cancelación de Entrevista - " . $jobOffer->getTitle();
        $message = "Hola " . $userData['firstName'] . ", te informamos que la entrevista para el puesto " . $jobOffer->getTitle() . " ha sido cancelada por la empresa.";
        MailService::send($userData['email'], $subject, $message);
    }

    public function declineApplicant($studentId, $jobOfferId) {
        try {
            // 1. Ejecutar el cambio de estado
            $this->applicationDAO->updateStatus($studentId, $jobOfferId, 'declined');

            // 2. Traer SOLO al alumno afectado (Eficiencia pura)
            $applicationData = $this->applicationDAO->getSpecificApplicant($studentId, $jobOfferId);

            if ($applicationData) {
                $jobOffer = $this->jobOfferRepo->getById($jobOfferId);
                
                // 3. Delegar el armado del mail a un método privado o Service
                $this->sendDeclineEmail($applicationData, $jobOffer);
            }

            // 4. Redirigir con un mensaje de éxito
            $this->showApplicants($jobOfferId, "Postulante declinado y notificado correctamente.", "success");

        } catch (Exception $ex) {
            $this->showApplicants($jobOfferId, "Error al procesar la baja: " . $ex->getMessage(), "danger");
        }
    }

     // Método privado para no ensuciar la lógica principal
    private function sendDeclineEmail($userData, $jobOffer) {
        $subject = "Actualización de Postulación: " . $jobOffer->getTitle();
        
        // Un toque más "Pro" en el diseño del mail
        $message = "
            <div style='font-family: Arial, sans-serif; border: 1px solid #eee; padding: 20px;'>
                <h2 style='color: #d9534f;'>Hola " . $userData['firstName'] . "</h2>
                <p>Lamentamos informarte que tu postulación para la oferta 
                <strong>" . $jobOffer->getTitle() . "</strong> ha sido declinada.</p>
                <p>Te agradecemos por el interés y te invitamos a seguir aplicando a otras búsquedas en <strong>Let's Work</strong>.</p>
                <hr>
                <small>Este es un mensaje automático, por favor no lo respondas.</small>
            </div>";

        MailService::send($userData['email'], $subject, $message);
    }
}