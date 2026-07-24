<?php
namespace Controllers;

use Repositories\JobOfferRepository as JobOfferRepository;
use Repositories\CompanyRepository as CompanyRepository;
use Repositories\StudentRepository as StudentRepository;
use Repositories\UserRepository as UserRepository;
use DAO\JobPositionDAOMySQL as JobPositionDAO;
use DAO\ApplicationDAO as ApplicationDAO;
use DAO\NotificationDAO as NotificationDAO;
use DAO\StudentPreferenceDAO;
use Models\JobOffer as JobOffer;
use \Exception as Exception;
use Dompdf\Dompdf;
use Utils\MailService as MailService;

class AdminJobOfferController
{
    private $jobOfferRepo;
    private $companyRepo;
    private $studentRepo;
    private $userRepo;
    private $jobPositionDAO;
    private $applicationDAO;
    private StudentPreferenceDAO $studentPreferenceDAO;
    private NotificationDAO $notificationDAO;

    public function __construct()
    {
        $this->jobOfferRepo = new JobOfferRepository();
        $this->companyRepo = new CompanyRepository();
        $this->studentRepo = new StudentRepository();
        $this->userRepo = new UserRepository();
        $this->jobPositionDAO = new JobPositionDAO();
        $this->applicationDAO = new ApplicationDAO();
        $this->studentPreferenceDAO = new StudentPreferenceDAO();
        $this->notificationDAO = new NotificationDAO();
    }

    public function showAddView($companyId = null, $message = "")
    {
        try {
            // 1. Siempre traemos los puestos
            $jobPositions = $this->jobPositionDAO->getAll(); 

            // 2. Si hay ID, buscamos el objeto de ESA empresa
            $company = null;
            $companiesList = null;

            if ($companyId) {
                $company = $this->companyRepo->getById($companyId);
            } else {
                // Si no hay ID, traemos TODAS para el desplegable
                $companiesList = $this->companyRepo->getAll();
            }

            // Pasamos TODO a la vista
            require_once(ADMIN_VIEWS . "job-offer-add.php");
        } catch (Exception $ex) {
            echo "Error: " . $ex->getMessage();
        }
    }

   public function add()
    {
        if ($_POST) {
            try {
                $jobOffer = new JobOffer();
                
                // 1. Datos básicos
                $jobOffer->setTitle($_POST["title"]);
                $jobOffer->setDescription($_POST["description"]);
                $jobOffer->setSalary($_POST["salary"]);
                $jobOffer->setStartDate($_POST["startDate"]);
                $jobOffer->setDeadline($_POST["deadline"]);
                $jobOffer->setCompanyId($_POST["companyId"]);
                $jobOffer->setJobPositionId($_POST["jobPositionId"]);
                $jobOffer->setActive(true);

                $flyerPath = null;
                if (isset($_FILES['flyer']) && $_FILES['flyer']['error'] !== UPLOAD_ERR_NO_FILE) {

                if ($_FILES['flyer']['error'] !== UPLOAD_ERR_OK) {
                    $uploadErrors = [
                        UPLOAD_ERR_INI_SIZE  => 'El archivo es demasiado pesado para el servidor.',
                        UPLOAD_ERR_FORM_SIZE => 'El archivo supera el tamaño máximo permitido.',
                        UPLOAD_ERR_PARTIAL   => 'La subida se interrumpió. Probá de nuevo.',
                    ];
                    throw new Exception($uploadErrors[$_FILES['flyer']['error']] ?? 'Error al subir el archivo.');
                }

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

                // 3. Guardar en BD
                $newId = $this->jobOfferRepo->add($jobOffer);

                if($newId > 0) {
                    // Le asignamos el ID al objeto para que el motor de alertas sepa cuál es
                    $jobOffer->setJobOfferId($newId);
                    
                    // Disparamos la función de notificaciones que armamos antes
                    $this->notifyInterestedStudents($jobOffer);
                }

                header("location: " . FRONT_ROOT . "AdminJobOffer/showActiveJobOffers");
                
            } catch (Exception $ex) {
            // Si no hay companyId en el POST, intentamos mandarlo a una vista general o mostrar el error
            $companyId = isset($_POST["companyId"]) ? $_POST["companyId"] : null;
            $this->showAddView($companyId, "Error: " . $ex->getMessage());
            }
        }
    }

   public function showListView($companyId)
    {
        try {
            $company = $this->companyRepo->getById($companyId);
            $jobOfferList = $this->jobOfferRepo->getByCompanyId($companyId);
            
            $companiesList = $this->companyRepo->getAll(); 
            
            $careerList = $this->jobPositionDAO->getAll(); 

            require_once(ADMIN_VIEWS . "job-offer-list.php");
        } catch (Exception $ex) {
            echo "Error: " . $ex->getMessage();
        }
    }

    public function showModifyJobOfferView($jobOfferId)
    {
        try {
            // 1. Buscamos la oferta específica que queremos editar
            $jobOffer = $this->jobOfferRepo->getById($jobOfferId);

            if($jobOffer) {
                // 2. Necesitamos estas listas para llenar los <select> del formulario
                $companiesList = $this->companyRepo->getAll();
                $jobPositionList = $this->jobPositionDAO->getAll();

                // 3. Cargamos la vista de modificación
                require_once(ADMIN_VIEWS . "modify-jobOffer-view.php");
            } else {
                // Si por alguna razón no existe el ID, volvemos al listado con un error
                echo "Job Offer not found.";
            }
        } catch (Exception $ex) {
            echo "Error: " . $ex->getMessage();
        }
    }

    public function modifyJobOffer($params) // Recibimos el array que manda el Router
    {
        try {
            // Extraemos los datos del array usando los nombres del 'name' del formulario
            $jobOfferId = $params["jobOfferId"];
            $title = $params["title"];
            $startDate = $params["startDate"];
            $deadline = $params["deadline"];
            $description = $params["description"];
            $salary = $params["salary"];
            $active = $params["active"];
            $jobPositionId = $params["jobPositionId"];
            $companyId = $params["companyId"];

            // Creamos el objeto
            $jobOffer = new JobOffer();
            $jobOffer->setJobOfferId($jobOfferId);
            $jobOffer->setTitle($title);
            $jobOffer->setStartDate($startDate);
            $jobOffer->setDeadline($deadline);
            $jobOffer->setDescription($description);
            $jobOffer->setSalary($salary);
            $jobOffer->setActive($active);
            $jobOffer->setJobPositionId($jobPositionId);
            $jobOffer->setCompanyId($companyId);

            // Llamamos al repositorio para actualizar
            $this->jobOfferRepo->update($jobOffer);

            // Redirigimos al listado de la empresa
            header("Location: " . FRONT_ROOT . "AdminJobOffer/showListView/" . $companyId);

        } catch (Exception $ex) {
            echo "Error al modificar: " . $ex->getMessage();
        }
    }

    public function deleteJobOffer($jobOfferId, $companyId)
    {
        try {
            $this->jobOfferRepo->deleteOffer($jobOfferId);
            
            // Redirigimos al listado de la empresa para ver los cambios
            header("Location: " . FRONT_ROOT . "AdminJobOffer/showListView/" . $companyId);
        } catch (Exception $ex) {
            echo "Error al eliminar: " . $ex->getMessage();
        }
    }

    public function restoreJobOffer($jobOfferId, $companyId)
    {
        try {
            // Usamos el método que ya creamos antes, pero enviando 'true' para activar
            $this->jobOfferRepo->updateActiveStatus($jobOfferId, true);
            
            header("Location: " . FRONT_ROOT . "AdminJobOffer/showListView/" . $companyId);
        } catch (Exception $ex) {
            echo "Error al restaurar: " . $ex->getMessage();
        }
    }

    public function showActiveJobOffers() {
        $_SESSION['last_job_offer_list'] = 'showActiveJobOffers';
        $this->processExpiredOffers();   
        
        $jobOfferList = $this->jobOfferRepo->getOpenOffers();

        $companiesList = $this->companyRepo->getAll();

        require_once(ADMIN_VIEWS."admin-active-offers-list.php");
    }

    public function showExpiredJobOffers() {
        $_SESSION['last_job_offer_list'] = 'showExpiredJobOffers';
        $allOffers = $this->jobOfferRepo->getAll();
        $today = date("Y-m-d");

        // Filtramos: las que ya pasaron de fecha O las que el admin desactivó manualmente
        $jobOfferList = array_filter($allOffers, function($offer) use ($today) {
            return ($offer->getDeadline() < $today || $offer->getActive() == false);
        });

        $filter = $_GET['positionFilter'] ?? null;
        if (!empty($filter)) {
            $filter = strtolower($filter);
            $jobOfferList = array_filter($jobOfferList, function($offer) use ($filter) {
                return strpos(strtolower($offer->getTitle()), $filter) !== false;
            });
        }
        $companiesList = $this->companyRepo->getAll();

        require_once(ADMIN_VIEWS."admin-expired-offers-list.php");
    }

    public function showApplicants($jobOfferId)
    {
        try {
            // 1. Opcional: Traer los datos de la oferta para mostrar el título en la vista
            $jobOffer = $this->jobOfferRepo->getById($jobOfferId);
            
            // 2. Traer la lista de alumnos postulados usando el DAO de aplicaciones
            // Nota: Asegurate de tener $this->applicationDAO inicializado en el constructor
            $applicantList = $this->applicationDAO->getApplicantsByOffer($jobOfferId);

            // 3. Cargar la vista
            require_once(ADMIN_VIEWS . "admin-job-offer-applicants.php");
            
        } catch (Exception $ex) {
            echo "Error al obtener postulantes: " . $ex->getMessage();
        }
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

    public function generateApplicantsPDF($jobOfferId) 
    {
        try {
            require_once(ROOT . "Vendor/dompdf/autoload.inc.php"); 

            // 2. Instancia con el namespace completo
            $dompdf = new Dompdf(); 

            $jobOffer = $this->jobOfferRepo->getById($jobOfferId);
            $applicantList = $this->applicationDAO->getApplicantsByOffer($jobOfferId);

            if ($jobOffer) {
                ob_start();
                require_once(ADMIN_VIEWS . "pdf-applicants-template.php");
                $html = ob_get_clean();

                ob_end_clean();

                $dompdf->loadHtml($html);
                $dompdf->setPaper('A4', 'portrait');
                $dompdf->render();

                // Esto abre el PDF en una pestaña nueva
                $dompdf->stream("Applicants_" . $jobOffer->getTitle() . ".pdf", array("Attachment" => false));
            }
        } catch (Exception $ex) {
            // Si falla, mostramos el error en la pantalla normal
            echo "Error generating PDF: " . $ex->getMessage();
        }
    }

   private function processExpiredOffers() 
    {
        try {
            $expiredOffers = $this->jobOfferRepo->getExpiredToNotify();

            foreach ($expiredOffers as $offer) {
                $applicants = $this->applicationDAO->getApplicantsByOffer($offer->getJobOfferId());

                // Solo mandamos mails y marcamos como notificada si REALMENTE hay gente a quien avisar
                if (!empty($applicants)) {
                    foreach ($applicants as $app) {
                        $to = $app['email'];
                        $subject = "Job Offer Closed: " . $offer->getTitle();
                        $message = "<h2>Hello " . $app['firstName'] . "</h2>" .
                                "<p>The application period for <strong>" . $offer->getTitle() . "</strong> has ended.</p>" .
                                "<p>Thank you for participating in this process.</p>";

                        MailService::send($to, $subject, $message);
                    }
                    // Si llegamos acá, es porque procesamos alumnos
                    $this->jobOfferRepo->updateNotifiedStatus($offer->getJobOfferId(), true);
                } else {
                    // OPCIONAL: Si no hay alumnos, quizás quieras marcarla como notificada igual 
                    // para que no la siga buscando el DAO, o dejarla en 0 hasta que decidas qué hacer.
                    // Mi consejo: Márcala como notificada para limpiar la base de datos.
                    $this->jobOfferRepo->updateNotifiedStatus($offer->getJobOfferId(), true);
                }
            }
        } catch (Exception $ex) {
            error_log("Error in processExpiredOffers: " . $ex->getMessage());
        }
    }

    public function ShowAnalytics() {

        $offerStats = $this->jobOfferRepo->GetStats();
        $topPositions = $this->jobOfferRepo->GetTopPositions();
        
        require_once(ADMIN_VIEWS . "admin-analytics.php");
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
}