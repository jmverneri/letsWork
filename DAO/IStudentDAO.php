<?php
    namespace DAO;

    use Models\Student as Student;

    interface IStudentDAO
    {
        function getAll();
        function getStudentByMail($email);
        
    }
?>