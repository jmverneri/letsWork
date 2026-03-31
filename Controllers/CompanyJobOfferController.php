<?php
namespace Controllers;

use Services\JobOfferService;
use Repositories\CompanyRepository;   
use Repositories\CareerRepository;
use Repositories\JobOfferRepository;
use Repositories\JobPositionRepository;  
use DAO\NotificationDAO as NotificationDAO;
use DAO\StudentPreferenceDAO;
use Models\JobOffer;
use Utils\Utils;
use Exception;

class CompanyJobOfferController
{
    private CompanyRepository $companyRepo;
    private CareerRepository $careerRepo;
    private JobOfferRepository $jobOfferRepo;
    private JobPositionRepository $jobPositionRepo;  
    private StudentPreferenceDAO $studentPreferenceDAO;
    private NotificationDAO $notificationDAO;

    public function __construct()
    {
        Utils::checkCompanySession();
        $this->jobOfferRepo = new JobOfferRepository();
        $this->jobPositionRepo = new JobPositionRepository();
        $this->companyRepo = new CompanyRepository();
        $this->careerRepo = new CareerRepository();
        $this->studentPreferenceDAO = new StudentPreferenceDAO();
        $this->notificationDAO = new NotificationDAO();
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
            // Podrías validar aquí que la oferta pertenezca a la empresa logueada
            $jobOffer = $this->jobOfferRepo->getById($jobOfferId);
            
            // Usamos el Service para obtener la data procesada
            // (Asegúrate de que tu DAO devuelva info útil del estudiante)
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
            
            // ¡OJO! No tocamos $jobOffer->setActive() ni ->setCompanyId() 
            // porque ya los trae del objeto original que recuperamos en el paso 1.

            // 3. Persistimos el objeto completo
            $this->jobOfferRepo->update($jobOffer);
            
            header("Location: " . FRONT_ROOT . "CompanyJobOffer/listMyOffers");
            exit();
        } catch (Exception $ex) {
            $errorMessage = $ex->getMessage();
            $this->showEditForm($request["jobOfferId"]);
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
}