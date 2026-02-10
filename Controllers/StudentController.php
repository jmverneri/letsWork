<?php

    namespace Controllers;

    use Repositories\StudentRepository;
    use Repositories\CareerRepository;
    use Models\Student;
    use Models\Career;
    use Utils\Utils;

    class StudentController
    {
        private StudentRepository $studentRepo;
        private CareerRepository $careerRepo;

        private array $studentList = [];
        private array $careerList = [];

        public function __construct()
        {
            
            $this->studentRepo = new StudentRepository();
            $this->careerRepo = new CareerRepository();
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

        public function showStudentProfile()
        {
            Utils::checkStudentSession();
            $user = $_SESSION['loggedUser'];

            try {
                $student = $this->studentRepo->getByUserId($user->getUserId());

                if (!$student) {
                    $_SESSION['login_error'] = "Perfil no encontrado.";
                    header("Location: " . FRONT_ROOT . "Home/index");
                    exit();
                }

                // Aquí aplicamos tu validación: el repo busca en BD o en API automáticamente
                $career = null;
                if ($student->getCareerId()) {
                    $career = $this->careerRepo->getById($student->getCareerId());
                }

                require_once(STUDENT_VIEWS . "student-profile.php");

            } catch (\Exception $ex) {
                // Loguear error o mostrar mensaje
                $message = "Hubo un problema al cargar los datos.";
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

        public function studentRegistration($email, $password, $confirmPass)
        {
            if ($password === $confirmPass) {

                $student = $this->studentRepo->getStudentByMail($email);
                $student->setPassword($password);

                $this->studentRepo->add($student);

                require_once(VIEWS_PATH . "student-profile.php");
            }
        }

        public function showAddView()
        {
            require_once(VIEWS_PATH . "student-add.php");
        }
    }
