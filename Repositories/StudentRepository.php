<?php
    namespace Repositories;

    use DAO\UserDAOMySQL as UserDAO;
    use DAO\StudentDAOApi;
    use DAO\StudentDAOMySQL;
    use Models\Student;
    use Models\User;

    class StudentRepository {
        private $api;
        private $db;
        private $userDAO;
        private $user;

        public function __construct() {
            $this->api = new StudentDAOAPI();
            $this->db = new StudentDAOMySQL();
            $this->userDAO = new UserDAO();
            $this->user = new User();
        }

        public function getAndSyncByEmail($email) {
            // 1. Buscamos localmente
            $student = $this->userDAO->getByEmail($email);

            if (!$student) {
                // 2. Buscamos en la API de Python
                $data = $this->api->getByEmail($email);

                if ($data) {
                    // --- PASO A: Crear el Objeto User y guardarlo ---
                    $user = new \Models\User();
                    $user->setEmail($data['email']);
                    $user->setPassword(password_hash($data['dni'], PASSWORD_DEFAULT));
                    $user->setRole("student");
                    $user->setActive(true);

                    // Guardamos el usuario y obtenemos su ID automático
                    $userId = $this->userDAO->add($user); 

                    // --- PASO B: Crear el Objeto Student ---
                    $newStudent = new \Models\Student();
                    $newStudent->setUserId($userId); // El cruce de tablas
                    $newStudent->setFirstName($data['firstName']);
                    $newStudent->setLastName($data['lastName']);
                    $newStudent->setDni($data['dni']);
                    $newStudent->setFileNumber($data['fileNumber']);
                    $newStudent->setGender($data['gender']);
                    $newStudent->setBirthDate($data['birthDate']);
                    $newStudent->setPhoneNumber($data['phoneNumber']);
                    $newStudent->setCareerId($data['careerId']);
                    $newStudent->setActive(true);

                    // --- PASO C: Guardar el Student en MySQL ---
                    $this->db->add($newStudent);

                    $student = $newStudent;
                }
            }
            return $student;
        }

        public function getByUserId($userId)
        {
            return $this->db->getByUserId($userId);
        }

        public function getAll() {
            $apiData = $this->api->getAll(); 
            $dbUsers = $this->userDAO->getAll(); 

            $registeredEmails = array();
            foreach($dbUsers as $user) {
                $registeredEmails[] = $user->getEmail();
            }

            foreach($apiData as $key => $student) {
                $apiData[$key]['isRegistered'] = in_array($student['email'], $registeredEmails);
            }

            // --- AGREGAR ESTO PARA ORDENAR POR APELLIDO ---
            usort($apiData, function($a, $b) {
                return strcmp($a['lastName'], $b['lastName']);
            });

            return $apiData;
        }

        public function getAndSyncByDni($dni) {
            // 1. Buscamos primero en nuestra DB local (usando el DAO de MySQL)
            $student = $this->db->getByDni($dni);

            if (!$student) {
                // 2. Si no existe, lo buscamos en la API
                $data = $this->api->getByDni($dni);

                if ($data) {
                    // --- REUTILIZAMOS TU LÓGICA DE REGISTRO ---
                    
                    // Creamos el User (para el login)
                    $user = new User();
                    $user->setEmail($data['email']);
                    $user->setPassword(password_hash($data['dni'], PASSWORD_DEFAULT));
                    $user->setRole("student");
                    $user->setActive(true);
                    
                    $userId = $this->userDAO->add($user); 

                    // Creamos el Student local
                    $newStudent = new Student();
                    $newStudent->setUserId($userId);
                    $newStudent->setFirstName($data['firstName']);
                    $newStudent->setLastName($data['lastName']);
                    $newStudent->setDni($data['dni']);
                    $newStudent->setFileNumber($data['fileNumber']);
                    $newStudent->setGender($data['gender']);
                    $newStudent->setBirthDate($data['birthDate']);
                    $newStudent->setPhoneNumber($data['phoneNumber']);
                    $newStudent->setCareerId($data['careerId']);
                    $newStudent->setActive(true);

                    $this->db->add($newStudent);
                    
                    // Retornamos el objeto recién creado (que ahora ya tiene su ID de MySQL)
                    $student = $this->db->getByDni($dni);
                }
            }
            return $student;
        }

        public function GetById($id) {
            return $this->db->getById($id);
        }
    }