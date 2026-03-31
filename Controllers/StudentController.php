<?php

    namespace Controllers;

    use Repositories\StudentRepository;
    use Repositories\CareerRepository;
    use Repositories\JobOfferRepository;
    use Repositories\JobPositionRepository;
    use Repositories\UserRepository;
    use Models\Student;
    use Models\Career;
    use Utils\Utils;
    use DAO\StudentPreferenceDAO;
    use DAO\NotificationDAO;
    use DAO\SubjectDAO;
    use Dompdf\Dompdf;
    use Dompdf\Options;

    class StudentController
    {
        private StudentRepository $studentRepo;
        private CareerRepository $careerRepo;
        private StudentPreferenceDAO $studentPreferenceDAO;
        private JobPositionRepository $jobPositionRepo;
        private JobOfferRepository $jobOfferRepo;
        private UserRepository $userRepo;
        private NotificationDAO $notificationDAO;
        private SubjectDAO $subjectDAO;

        private array $studentList = [];
        private array $careerList = [];

        public function __construct()
        {
            
            $this->studentRepo = new StudentRepository();
            $this->careerRepo = new CareerRepository();
            $this->studentPreferenceDAO = new StudentPreferenceDAO();
            $this->notificationDAO = new NotificationDAO();
            $this->jobPositionRepo = new JobPositionRepository();
            $this->jobOfferRepo = new JobOfferRepository();
            $this->userRepo = new UserRepository();
            $this->subjectDAO = new SubjectDAO();
        }

        public function showStudentRegistration()
        {
            require_once(VIEWS_PATH . "registration.php");
        }

        public function showStudentProfileByMail($email)
        {
            $this->studentRepo->getAndSyncByEmail($email);
        }

        public function showListView()
        {
            Utils::checkSession();

            $students = $this->studentRepo->getAll();
            $careers  = $this->careerRepo->getAll();

            /**
             * Armamos un mapa careerId => description
             * para evitar loops innecesarios
             */
            $careerMap = [];
            foreach ($careers as $career) {
                $careerMap[$career->getCareerId()] = $career->getDescription();
            }

            /**
             * ViewModel / DTO
             */
            $studentsView = [];

            foreach ($students as $student) {
                $user = $this->userRepo->getById($student->getUserId());

                $studentsView[] = [
                    'fileNumber' => $student->getFileNumber(),
                    'firstName'  => $student->getFirstName(),
                    'lastName'   => $student->getLastName(),
                    'gender'     => $student->getGender(),
                    'email'      => $user ? $user->getEmail() : null,
                    'career'     => $careerMap[$student->getCareerId()] ?? null,
                ];
            }

            require_once(ADMIN_VIEWS . "student-list.php");
        }

        public function showStudentProfile($message = "", $errorMessage = "") {
            Utils::checkStudentSession();
            $user = $_SESSION['loggedUser'];

            try {
                $student = $this->studentRepo->getByUserId($user->getUserId());

                if (!$student) {
                    $_SESSION['login_error'] = "Perfil no encontrado.";
                    header("Location: " . FRONT_ROOT . "Home/index");
                    exit();
                }

                $studentId = $student->getStudentId();
        
                $notifications = $this->notificationDAO->getUnreadByStudent($studentId);
                $cantNotif = count($notifications);

                $career = null;
                if ($student->getCareerId()) {
                    $career = $this->careerRepo->getById($student->getCareerId());
                }

                $approvedSubjects = $this->subjectDAO->getApprovedByStudent($studentId);

                // CARGA DE VISTA
                require_once(STUDENT_VIEWS . "student-profile.php");

            } catch (\Exception $ex) {
                $errorMessage = "No se pudo cargar el perfil: " . $ex->getMessage();
                require_once(VIEWS_PATH . "login.php");
            }
        }

        public function studentValidation($email)
        {
            $student = $this->studentRepo->getAndSyncByEmail($email);

            if ($student !== null) {
                require_once(VIEWS_PATH . "student-registration.php");
            } else {
                $message = "This mail doesn't exist";
                require_once(VIEWS_PATH . "login.php");
            }
        }

        public function studentRegistration($email, $password, $confirmPass) {
            if ($password === $confirmPass) {
                $student = $this->studentRepo->getAndSyncByEmail($email);
                $student->setPassword($password);

                // En lugar de llamar a la vista, llama a la FUNCIÓN que carga el perfil
                $this->showStudentProfile("Registro exitoso"); 
            }
        }

        public function showAddView()
        {
            require_once(VIEWS_PATH . "student-add.php");
        }

        public function savePreferences($preferences = []) 
        {
            Utils::checkStudentSession();
            $user = $_SESSION['loggedUser'];

            try {
                // 1. Buscamos el perfil del alumno usando el ID del usuario logueado
                $student = $this->studentRepo->getByUserId($user->getUserId());

                if (!$student) {
                    throw new \Exception("No se encontró el perfil de estudiante.");
                }

                // 2. Ahora sí tenemos el studentId real del modelo Student
                $studentId = $student->getStudentId();

                $this->studentPreferenceDAO->clearPreferences($studentId);

                $actualList = (isset($preferences['preferences'])) ? $preferences['preferences'] : $preferences;
                if(!empty($actualList) && is_array($actualList)) {
                                             
                    foreach($actualList as $jobPositionId) {
                        
                        $idFinal = is_array($jobPositionId) ? $jobPositionId[0] : $jobPositionId;

                        $this->studentPreferenceDAO->addPreference($studentId, $idFinal); 
                    }
                }
                
                $message = "Tus preferencias han sido actualizadas con éxito.";
                $this->showStudentProfile($message); 

            } catch (\Exception $ex) {
                $this->showStudentProfile("Error: " . $ex->getMessage());
            }
        }

        public function showPreferencesView($message = "")
        {
            Utils::checkStudentSession();
            $user = $_SESSION['loggedUser'];

            try {
                $student = $this->studentRepo->getByUserId($user->getUserId());
                
                $allPositions = $this->jobPositionRepo->getAll();

                // 3. Filtramos: Solo dejamos las que coincidan con la carrera del alumno
                $filteredPositions = array_filter($allPositions, function($pos) use ($student) {
                    return $pos->getCareerId() == $student->getCareerId();
                });

                require_once(STUDENT_VIEWS . "student-preferences.php");

            } catch (\Exception $ex) {
                $message = "Error al cargar preferencias.";
                $this->showStudentProfile($message);
            }
        }

        public function generateCV($studentId) {
            if (ob_get_length()) ob_end_clean();
            // 1. Obtener los datos del estudiante y sus materias/experiencia
            $student = $this->studentRepo->getById($studentId);
            if(!$student) {
                return; 
            }
            $user = $this->userRepo->GetById($student->getUserId());
            $loggedUser = $_SESSION["loggedUser"];
    
            // Si no es admin y el usuario del CV no es el que está logueado...
            if($loggedUser->getRole() != "admin" && $loggedUser->getUserId() != $user->getUserId()) {
                header("location: " . FRONT_ROOT . "Home/Index");
                return;
            }

            // 2. Configurar Dompdf
            try {
                $options = new Options();
                $options->set('isHtml5ParserEnabled', true);
                $options->set('isRemoteEnabled', true); // Importante para cargar imágenes/logos

                $dompdf = new Dompdf($options);

                // 3. Crear el diseño HTML (lo ideal es que sea un string con CSS inline)
                $html = '
                    <html>
                        <head>
                            <style>
                                @page { margin: 0; }
                                body { font-family: "Helvetica", sans-serif; margin: 0; padding: 0; color: #333; }
                                .cv-table { width: 100%; height: 100%; border-collapse: collapse; }
                                .sidebar { width: 30%; background-color: #1a2a3a; color: #ffffff; padding: 40px 20px; vertical-align: top; }
                                .sidebar h2 { font-size: 18px; text-transform: uppercase; margin-bottom: 30px; border-bottom: 1px solid #34495e; padding-bottom: 10px; }
                                .info-block { margin-bottom: 25px; }
                                .info-label { display: block; font-size: 10px; color: #95a5a6; text-transform: uppercase; font-weight: bold; }
                                .info-text { font-size: 12px; word-wrap: break-word; }
                                .main-content { width: 70%; padding: 50px 40px; vertical-align: top; background-color: #ffffff; }
                                .header-name { font-size: 30px; font-weight: bold; color: #1a2a3a; margin: 0; text-transform: uppercase; }
                                .header-title { font-size: 14px; color: #3498db; margin-top: 5px; font-weight: bold; }
                                .section-title { font-size: 14px; font-weight: bold; color: #1a2a3a; border-bottom: 2px solid #3498db; padding-bottom: 5px; margin-top: 30px; margin-bottom: 15px; text-transform: uppercase; }
                                .item-desc { font-size: 12px; margin-top: 5px; text-align: justify; line-height: 1.4; }
                            </style>
                        </head>
                        <body>
                            <table class="cv-table">
                                <tr>
                                    <td class="sidebar">
                                        <h2>Contacto</h2>
                                        <div class="info-block">
                                            <span class="info-label">Email</span>
                                            <span class="info-text">' . htmlspecialchars($user->getEmail()) . '</span>
                                        </div>
                                        <div class="info-block">
                                            <span class="info-label">Teléfono</span>
                                            <span class="info-text">' . htmlspecialchars($student->getPhoneNumber()) . '</span>
                                        </div>
                                        <div class="info-block">
                                            <span class="info-label">DNI</span>
                                            <span class="info-text">' . htmlspecialchars($student->getDni()) . '</span>
                                        </div>
                                        <div class="info-block">
                                            <span class="info-label">Legajo</span>
                                            <span class="info-text">' . htmlspecialchars($student->getFileNumber()) . '</span>
                                        </div>
                                    </td>

                                    <td class="main-content">
                                        <h1 class="header-name">' . htmlspecialchars($student->getFirstName()) . ' ' . htmlspecialchars($student->getLastName()) . '</h1>
                                        <div class="header-title">Estudiante - Técnico Superior en Programación</div>

                                        <div class="section-title">Información Académica</div>
                                        <p class="item-desc">
                                            Actualmente cursando la carrera de Programación en la Universidad Tecnológica Nacional. 
                                            Miembro activo de la plataforma Lets Work con legajo nro. <strong>' . htmlspecialchars($student->getFileNumber()) . '</strong>.
                                        </p>';

                                        // EJEMPLO DINÁMICO: Si tuvieras una lista de habilidades o materias
                                        /*
                                        if(!empty($habilidades)) {
                                            $html .= '<div class="section-title">Habilidades</div><ul>';
                                            foreach($habilidades as $hab) {
                                                $html .= '<li style="font-size: 12px;">' . htmlspecialchars($hab->getNombre()) . '</li>';
                                            }
                                            $html .= '</ul>';
                                        }
                                        */

                        $html .= '  <div class="section-title">Estado de Cuenta</div>
                                        <p class="item-desc">
                                            <strong>Rol en el sistema:</strong> ' . ucfirst($user->getRole()) . '<br>
                                            <strong>ID de Estudiante:</strong> ' . $student->getStudentId() . '
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </body>
                        </html>';

                // 4. Cargar el HTML y generar
                $dompdf->loadHtml($html);
                $dompdf->setPaper('A4', 'portrait');
                $dompdf->render();

                // 5. Lanzar al navegador
                $dompdf->stream("CV_" . $student->getLastName() . ".pdf", ["Attachment" => false]);
            } catch (\Exception $ex) {
                echo "Error al generar PDF: " . $ex->getMessage();
            }   
        }
    }
