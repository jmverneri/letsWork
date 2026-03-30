<?php
    namespace Controllers;

    use Repositories\JobOfferRepository as JobOfferRepository;
    use Repositories\CompanyRepository as CompanyRepository;
    use Repositories\JobPositionRepository as JobPositionRepository;
    use Repositories\StudentRepository as StudentRepository;
    use DAO\ApplicationDAO as ApplicationDAO;
    use DAO\NotificationDAO;
    use Models\JobOffer as JobOffer;
    use \Exception as Exception;
    use Utils\Utils;


    class StudentJobOfferController
    {
        private $jobOfferRepo;
        private $companyRepo;
        private $jobPositionRepo;
        private $studentRepo;
        private $applicationDAO;
        private NotificationDAO $notificationDAO;
        

        public function __construct()
        {
            Utils::checkStudentSession();
            $this->jobOfferRepo = new JobOfferRepository();
            $this->companyRepo = new CompanyRepository();
            $this->companyRepo = new CompanyRepository();
            $this->studentRepo = new StudentRepository();
            $this->jobPositionRepo = new JobPositionRepository();
            $this->applicationDAO = new ApplicationDAO();
            $this->notificationDAO = new NotificationDAO();
        }

        public function showActiveJobOffers() 
        {
            // 1. Verificación de seguridad y datos del estudiante
            Utils::checkNav();
            $userLogged = $_SESSION["loggedUser"];
        
            $student = $this->studentRepo->getByUserId($userLogged->getUserId());

            if(!$student) {
                // Manejo de error si no es un estudiante válido
                require_once(VIEWS_PATH . "header.php");
                echo "Error: Student data not found.";
                return;
            }

            $studentCareerId = $student->getCareerId();

            // 2. Obtención de datos brutos
            $allOffers = $this->jobOfferRepo->getAll();
            $allPositions = $this->jobPositionRepo->getAll();

            // 3. OPTIMIZACIÓN: Creamos un "mapa" de posiciones indexado por ID.
            $positionsMap = [];
            foreach($allPositions as $pos) {
                $positionsMap[$pos->getJobPositionId()] = $pos;
            }

            // 4. FILTRADO: Aplicamos la lógica de negocio
           
            $jobOfferList = array_filter($allOffers, function($offer) use ($studentCareerId, $positionsMap) {
                $today = date("Y-m-d");    
                // Primero: La oferta debe estar activa
                if (!$offer->getActive()) {
                    return false;
                }

                if ($offer->getDeadline() < $today) {
                    return false;
                }

                // Segundo: Buscamos la posición en nuestro mapa usando el ID
                $posId = $offer->getJobPositionId();
                
                if (isset($positionsMap[$posId])) {
                    $position = $positionsMap[$posId];
                    // Tercero: El careerId de la posición debe coincidir con el del alumno
                    return ($position->getCareerId() == $studentCareerId);
                }

                return false;
            });

            // 5. Datos extra para la vista (nombres de empresas)
            $companiesList = $this->companyRepo->getAll();

            // 6. Carga de la vista
            require_once(STUDENT_VIEWS . "student-job-offers-list.php");
        }

        public function showOffersByCompany($companyId)
        {
            try {
                // 1. Identificar al estudiante y su carrera
                Utils::checkNav();
                $userLogged = $_SESSION["loggedUser"];
                $student = $this->studentRepo->getByUserId($userLogged->getUserId());

                if (!$student) {
                    throw new Exception("No se pudieron cargar los datos del estudiante.");
                }

                $studentCareerId = $student->getCareerId();

                // 2. Obtener la empresa y sus ofertas
                $company = $this->companyRepo->getById($companyId);
                $allOffers = $this->jobOfferRepo->getByCompanyId($companyId);
                
                // 3. Preparar el Mapa de Posiciones para el filtro rápido
                $allPositions = $this->jobPositionRepo->getAll();
                $positionsMap = [];
                foreach($allPositions as $pos) {
                    $positionsMap[$pos->getJobPositionId()] = $pos;
                }

                // 4. Filtrar: Activas + Carrera del Estudiante
                $jobOfferList = array_filter($allOffers, function($offer) use ($studentCareerId, $positionsMap) {
                    // Regla 1: Debe estar activa
                    if (!$offer->getActive()) return false;

                    // Regla 2: Debe pertenecer a la carrera del alumno
                    $posId = $offer->getJobPositionId();
                    if (isset($positionsMap[$posId])) {
                        return $positionsMap[$posId]->getCareerId() == $studentCareerId;
                    }

                    return false;
                });

                // 5. Datos extra para la vista
                $companiesList = $this->companyRepo->getAll(); 
                // Usamos $allPositions para que la vista pueda mostrar nombres de puestos
                $jobPositionsList = $allPositions; 

                require_once(STUDENT_VIEWS . "student-job-offers-list.php");

            } catch (Exception $ex) {
                // Es mejor mandar el error a una vista o usar un log
                echo "Error: " . $ex->getMessage();
            }
        }

        public function apply($jobOfferId) {
        try {
            Utils::checkNav();
            $userLogged = $_SESSION["loggedUser"];
            
            // Traemos al alumno para tener su ID de base de datos
            $student = $this->studentRepo->getByUserId($userLogged->getUserId());

            if($student) {
                // 1. Verificamos que no haya aplicado antes (Seguridad extra)
                if(!$this->applicationDAO->isStudentApplied($student->getStudentId(), $jobOfferId)) {
                    
                    $today = date("Y-m-d H:i:s");
                    
                    // 2. Guardamos la aplicación
                    $this->applicationDAO->add($student->getStudentId(), $jobOfferId, $today);
                    
                    $message = "¡Postulación exitosa!";
                } else {
                    $message = "Ya te has postulado a esta oferta anteriormente.";
                }
            }
            
            // 3. Redirigimos a la lista para que vea los cambios
            $this->showActiveJobOffers(); 

            } catch (Exception $ex) {
                echo "Error al aplicar: " . $ex->getMessage();
            }
        }

        public function showMyApplications() {
            Utils::checkNav();
            $userLogged = $_SESSION["loggedUser"];
            
            // Obtenemos el estudiante para tener su ID de base de datos
            $student = $this->studentRepo->getByUserId($userLogged->getUserId());

            if($student) {
                $applicationList = $this->applicationDAO->getApplicationsByStudent($student->getStudentId());
                
                // Cargamos la vista específica del historial
                require_once(STUDENT_VIEWS . "student-applications-history.php");
            } else {
                echo "Error: Student not found.";
            }
        }

        public function showOfferDetails($jobOfferId)
        {
            try {
                Utils::checkNav();
                $userLogged = $_SESSION["loggedUser"];
                $student = $this->studentRepo->getByUserId($userLogged->getUserId());

                if (!$student) {
                    throw new \Exception("No se pudieron cargar los datos del estudiante.");
                }

                $this->notificationDAO->markAsRead($student->getStudentId(), $jobOfferId);

                // 1. Obtenemos la oferta específica
                $jobOffer = $this->jobOfferRepo->getById($jobOfferId);

                if (!$jobOffer || !$jobOffer->getActive()) {
                    throw new \Exception("La oferta no existe o ya no está activa.");
                }

                // 2. Obtenemos los datos complementarios para mostrar en la ficha
                $company = $this->companyRepo->getById($jobOffer->getCompanyId());
                $jobPosition = $this->jobPositionRepo->getById($jobOffer->getJobPositionId());

                // 3. Verificamos que el alumno YA NO haya aplicado (para mostrar o no el botón de Postularse)
                $alreadyApplied = $this->applicationDAO->isStudentApplied($student->getStudentId(), $jobOfferId);

                // 4. Cargamos una vista de "Detalle"
                require_once(STUDENT_VIEWS . "student-job-offer-detail.php");

            } catch (\Exception $ex) {
                // Si hay error, lo mandamos a la lista con un mensaje
                $errorMessage = $ex->getMessage();
                $this->showActiveJobOffers();
            }
        }
    }
