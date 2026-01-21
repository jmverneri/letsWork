<?php
    namespace DAO;

    use Models\Student;

    interface IStudentDAO
    {
        /**
         * @return Student[]
         */
        public function getAll();

        /**
         * @param int $id
         * @return Student|null
         */
        public function getById($id);

        /**
         * @param string $email
         * @return Student|null
         */
        public function getByEmail($email);

        /**
         * @param Student $student
         * @return int filas afectadas
         */
        public function add(Student $student);
    }

?>