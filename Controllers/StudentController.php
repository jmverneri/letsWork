<?php

    namespace Controllers;

    use Repositories\StudentRepository;
    use Repositories\CareerRepository;
    use Models\Student;
    use Models\Career;
    use Utils\Utils;
    use DAO\StudentPreferenceDAO;
    use DAO\NotificationDAO;
    use Repositories\JobPositionRepository;

    class StudentController
    {
        private StudentRepository $studentRepo;
        private CareerRepository $careerRepo;
        private StudentPreferenceDAO $studentPreferenceDAO;
        private JobPositionRepository $jobPositionRepo;
        private NotificationDAO $notificationDAO;

        private array $studentList = [];
        private array $careerList = [];

        public function __construct()
        {
            
            $this->studentRepo = new StudentRepository();
            $this->careerRepo = new CareerRepository();
            $this->studentPreferenceDAO = new StudentPreferenceDAO();
            $this->notificationDAO = new NotificationDAO();
            $this->jobPositionRepo = new JobPositionRepository();
        }

        public function showStudentRegistration()
        {
            require_once(VIEWS_PATH . "registration.php");
        }

        public function showStudentProfileByMail($email)
        {
            $this->getStudentByMail($email);
        }

        public function showListView()
        {
            Utils::checkSession();

            $students = $this->studentDAO->getAll();
            $careers  = $this->careerDAO->getAll();

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
                $user = $this->userDAO->getById($student->getUserId());

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
        
                // Usamos la instancia que ya creaste en el constructor ($this->notificationDAO)
                $notifications = $this->notificationDAO->getUnreadByStudent($studentId);
                $cantNotif = count($notifications);

                $career = null;
                if ($student->getCareerId()) {
                    $career = $this->careerRepo->getById($student->getCareerId());
                }

                // CARGA DE VISTA
                require_once(STUDENT_VIEWS . "student-profile.php");

            } catch (\Exception $ex) {
                $errorMessage = "No se pudo cargar el perfil: " . $ex->getMessage();
                require_once(VIEWS_PATH . "login.php");
            }
        }

        public function studentValidation($email)
        {
            $student = $this->studentRepo->getStudentByMail($email);

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
    }
