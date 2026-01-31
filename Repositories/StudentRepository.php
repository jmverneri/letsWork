<?php
    namespace Repositories;

    use DAO\UserDAOMySQL as UserDAO;
    use DAO\StudentDAOApi;
    use DAO\StudentDAOMySQL;
    use Models\Student;

    class StudentRepository {
        private $api;
        private $db;
        private $userDAO;

        public function __construct() {
            $this->api = new StudentDAOApi();
            $this->db = new StudentDAOMySQL();
            $this->userDAO = new UserDAO();
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
            return $this->studentDAOMySQL->getByUserId($userId);
        }
    }