<?php
    namespace Controllers;

    use Repositories\StudentRepository;
    use Repositories\CompanyRepository;
    use Repositories\CareerRepository;
    use DAO\UserDAOMySQL;
    use DAO\StudentDAOMySQL;
    use DAO\SubjectDAO;
    use Models\Student;
    use Models\Career;
    use Models\User;
    use Models\Subject;
    use Utils\Utils;

    class AdminController
    {
        private StudentRepository $studentRepo;
        private CompanyRepository $companyRepo;
        private CareerRepository $careerRepo;
        private UserDAOMySQL $userDAO;
        private $viewMessage;
        private StudentDAOMySQL $studentDAO;
        private SubjectDAO $subjectDAO;
        private Subject $subject;

        public function __construct()
        {
            $this->studentRepo = new StudentRepository();
            $this->companyRepo = new CompanyRepository();
            $this->careerRepo  = new CareerRepository();
            $this->userDAO = new UserDAOMySQL();
            $this->studentDAO = new StudentDAOMySQL();
            $this->subjectDAO = new SubjectDAO();
            $this->subject = new Subject();
        }

        public function showStudentList($message = "")
        {
            Utils::checkNav();

            // 1. El Repo ahora devuelve un Array de Arrays (API + flag isRegistered)
            $studentList = $this->studentRepo->getAll(); 

            $registeredIds = array_map(function($student) {
                return $student['studentId']; 
            }, $studentList);

            require_once(ADMIN_VIEWS . "student-list.php");
        }

        public function updateCareers() 
        {
            Utils::checkAdminSession();
            
            // El Repository sabe que tiene que ir a la API y guardar en MySQL
            $this->careerRepo->syncFromApi();
            
            $_SESSION['message'] = "Carreras actualizadas correctamente desde la API.";
            header("Location: " . FRONT_ROOT . "Home/menuAdmin");
            exit();
        }
        //REVISAR
        /*public function updateCompanies() 
        {
            Utils::checkAdminSession();
            
            $this->companyRepo->syncFromApi();
            
            $_SESSION['message'] = "Empresas sincronizadas correctamente.";
            header("Location: " . FRONT_ROOT . "Home/menuAdmin");
            exit();
        }*/

        public function showDashboard()
        {
            Utils::checkNav();
        
            require_once(ADMIN_VIEWS . "admin-dashboard.php");
        }

        public function addAdmin()
        {
            Utils::checkNav();

            $user = new User();
            $user->setEmail($_POST["email"]);
            // IMPORTANTE: Hashear siempre la password
            $user->setPassword(password_hash($_POST["password"], PASSWORD_DEFAULT));
            $user->setRole("admin");
            $user->setActive(true);

            try {
                $this->userDAO->add($user);
                $this->viewMessage = "Admin created successfully";
            } catch (\Exception $ex) {
                $this->viewMessage = "Error creating admin: " . $ex->getMessage();
            }
            
            $this->showDashboard();
        }   

        public function removeAdmin($params)
        {
            \Utils\Utils::checkNav();

            // 1. Extraemos el ID del array que manda el Router (desde el $_POST)
            // Usamos el nombre 'userId' porque es el que pusiste en el <input name="userId">
            $userId = (isset($params['userId'])) ? (int)$params['userId'] : 0;

            // 2. Ahora sí podemos usar $userId para las validaciones
            if($_SESSION["loggedUser"]->getUserId() == $userId) {
                $this->showCreateUserForm("You cannot delete your own account.");
                return;
            }

            try {
                // 3. Pasamos el ID limpio al DAO
                if($userId > 0) {
                    $this->userDAO->delete($userId);
                    $this->showCreateUserForm("Administrator removido satisfactoriamente.");
                } else {
                    $this->showCreateUserForm("Admin ID Invalido.");
                }
            } catch (\Exception $ex) {
                $this->showCreateUserForm("Error removiendo admin.");
            }
        }

        public function restoreAdmin($params)
        {
            \Utils\Utils::checkNav();
            $userId = (isset($params['userId'])) ? (int)$params['userId'] : 0;

            try {
                $this->userDAO->activate($userId);
                $this->showCreateUserForm("Administrator restaurado satisfactoriamente.");
            } catch (\Exception $ex) {
                $this->showCreateUserForm("Error restaurando admin.");
            }
        }

        public function showCreateUserForm($message = "")
        {
            Utils::checkNav();
            $this->viewMessage = $message;
            
            $allUsers = $this->userDAO->getAll();
            
            // Filtramos los activos para la tabla principal
            $adminList = array_filter($allUsers, function($user) {
                return $user->getRole() === "admin" && $user->getActive() == true;
            });

            // Filtramos los inactivos para una sección de "Papelera" o "Historial"
            $inactiveAdmins = array_filter($allUsers, function($user) {
                return $user->getRole() === "admin" && $user->getActive() == false;
            });

            require_once(ADMIN_VIEWS . "add-admin.php");
        }

        // Método para mostrar el formulario de asignación
        public function showAddSubjectToStudent($studentId, $errorMessage) {
            Utils::checkAdminSession();
            
            // 1. Buscamos los datos del alumno para saber su carrera
            $student = $this->studentDAO->getById($studentId);
            
            // 2. Traemos SOLO las materias que pertenecen a la carrera de ese alumno
            $subjectDAO = new \DAO\SubjectDAO();
            $subjectList = $subjectDAO->getByCareer($student->getCareerId());

            require_once(ADMIN_VIEWS . "add-subject-to-student.php");
        }

        // Método para guardar en la base de datos
        public function addSubjectToStudent($formData) {
            Utils::checkAdminSession();
            
            // Extraemos los IDs del array que manda el Router
            $studentId = $formData['studentId'];
            $subjectId = $formData['subjectId'];

            try {
                $this->subjectDAO->addApprovedSubject($studentId, $subjectId);
                
                $message = "Materia asignada correctamente.";
                $this->showStudentList($message); 
            } catch (\Exception $ex) {
                $errorMessage = "Error: El alumno ya tiene esta materia aprobada o hubo un problema técnico.";
                $this->showAddSubjectToStudent($studentId, $errorMessage);
            }
        }

        public function showAddSubjectView($message = "") {
            Utils::checkAdminSession();
            
            // Traemos todas las carreras para el <select>
            $careerList = $this->careerRepo->getAll(); 
            
            require_once(ADMIN_VIEWS . "add-subject.php");
        }

        public function removeStudentSubject($params) {
            Utils::checkAdminSession();

            $studentId = (int)($params['studentId'] ?? 0);
            $subjectId = (int)($params['subjectId'] ?? 0);
            $dni       = $params['dni'] ?? null;

            try {
                if ($studentId > 0 && $subjectId > 0) {
                    $this->subjectDAO->removeApprovedSubject($studentId, $subjectId);
                }
                $this->showStudentAcademicView($dni);
            } catch (\Exception $ex) {
                $this->showStudentAcademicView($dni);
            }
        }

        public function addSubject($formData) {
            Utils::checkAdminSession();
            try {
                $subject = new \Models\Subject();
                $subject->setCareerId($formData['careerId']);
                $subject->setAsignatura($formData['asignatura']);
                $subject->setCursado($formData['cursado']);
                $subject->setHsSemanales($formData['hsSemanales']);
                $subject->setCargaHorariaTotal($formData['cargaHorariaTotal']);
                $subject->setCreditos($formData['creditos']);

                $this->subjectDAO->add($subject);
                $this->showAddSubjectView("Asignatura creada con éxito.");
            } catch (\Exception $ex) {
                $this->showAddSubjectView("Error: " . $ex->getMessage());
            }
        }

        public function showSubjectList($message = "") {
            Utils::checkAdminSession();
            $this->viewMessage = $message;

            try {
                // Traemos todas las materias sin filtro
                $subjectList = $this->subjectDAO->getAll();
                
                // También traemos las carreras para poder mostrar el nombre de la carrera en la tabla
                $careerList = $this->careerRepo->getAll();
                
                require_once(ADMIN_VIEWS . "subject-list.php");
            } catch (\Exception $ex) {
                $this->showDashboard(); // Si falla, volvemos al dashboard
            }
        }

        public function showEditSubjectView($subjectId)
        {
            Utils::checkAdminSession();

            try {
                // 1. Buscamos la asignatura específica por su ID
                $subject = $this->subjectDAO->getById($subjectId);

                if ($subject) {
                    // 2. Necesitamos la lista de carreras para el <select> de la vista
                    $careerList = $this->careerRepo->getAll();
                    
                    // 3. Cargamos la vista de edición
                    require_once(ADMIN_VIEWS . "edit-subject.php");
                } else {
                    $this->showSubjectList("La asignatura no existe o fue eliminada.");
                }
            } catch (\Exception $ex) {
                $this->showSubjectList("Error al cargar la edición: " . $ex->getMessage());
            }
        }

        public function editSubject($formData) {
            Utils::checkAdminSession();
            try {
                $subject = new Subject();
                $subject->setSubjectId($formData['subjectId']);
                $subject->setCareerId($formData['careerId']);
                $subject->setAsignatura($formData['asignatura']);
                $subject->setCursado($formData['cursado']);
                $subject->setHsSemanales($formData['hsSemanales']);
                $subject->setCargaHorariaTotal($formData['cargaHorariaTotal']);
                $subject->setCreditos($formData['creditos']);

                $this->subjectDAO->update($subject);

                $this->showSubjectList("Asignatura actualizada correctamente.");
            } catch (\Exception $ex) {
                $this->showSubjectList("Error al actualizar: " . $ex->getMessage());
            }
        }

        public function removeSubject($subjectId) {
            Utils::checkAdminSession();
            
            try {
                $this->subjectDAO->delete($subjectId);
                
                $message = "Asignatura desactivada correctamente (Borrado lógico).";
                $this->showSubjectList($message);
            } catch (\Exception $ex) {
                $this->showSubjectList("Error al intentar dar de baja la asignatura.");
            }
        }

        // 1. Vista de selección de carrera
        public function showCareerSelection() {
            Utils::checkAdminSession();
            $careerList = $this->careerRepo->getAll(); // Traemos todas las carreras
            require_once(ADMIN_VIEWS . "career-selection-subjects.php");
        }

        // 2. Vista de materias filtradas por carrera
        public function showSubjectListByCareer($careerId) {
            Utils::checkAdminSession();
            
            $subjectList = $this->subjectDAO->getByCareer($careerId);
            $career = $this->careerRepo->getById($careerId); // Para poner el título "Materias de X"

            require_once(ADMIN_VIEWS . "subject-list.php");
        }

        public function restoreSubject($subjectId) {
            Utils::checkAdminSession();
            try {
                $this->subjectDAO->restore($subjectId);
                
                $message = "Asignatura restaurada con éxito.";
                $this->showSubjectList($message);
            } catch (\Exception $ex) {
                $this->showSubjectList("Error al restaurar la asignatura.");
            }
        }

        public function showStudentAcademicView($dni) {
            Utils::checkAdminSession();
            
            // 1. Obtenemos el objeto estudiante 
            $student = $this->studentRepo->getAndSyncByDni($dni);

            if ($student) {
                // Al ser un objeto de nuestra DB, getStudentId() devuelve nuestro ID local
                $studentId = $student->getStudentId(); 
                
                $approvedSubjects = $this->subjectDAO->getApprovedByStudent($studentId);
                $allCareerSubjects = $this->subjectDAO->getByCareer($student->getCareerId());
                
                // 4. Filtramos las disponibles
                $availableSubjects = array_filter($allCareerSubjects, function($subject) use ($approvedSubjects) {
                    foreach($approvedSubjects as $approved) {
                        if($subject->getSubjectId() == $approved->getSubjectId()) return false;
                    }
                    return true;
                });

                $career = $this->careerRepo->getById($student->getCareerId());
                $careerName = ($career) ? $career->getDescription() : "Carrera no especificada";

                require_once(ADMIN_VIEWS . "student-academic.php");
            } else {
                $this->showStudentList("No se pudo encontrar al estudiante con DNI: $dni");
            }
        }
    }
