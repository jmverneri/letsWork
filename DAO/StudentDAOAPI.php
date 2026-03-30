<?php
namespace DAO;

use Models\Student;
use DAO\IStudentDAO;

class StudentDAOApi implements IStudentDAO {

    public function getByEmail($email) {
        $url = API_URL . 'students/email/' . $email;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('x-api-key: ' . API_KEY));
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($httpCode === 200) {
            return json_decode($response, true); // Retorna array con datos de Python
        }
        return null;
    }

   public function getAll() {
        $options = array("http" => array("header" => "x-api-key: " . API_KEY . "\r\n"));
        $context = stream_context_create($options);
        $response = @file_get_contents(API_URL . "students", false, $context);

        if($response) {
            return json_decode($response, true); // Retornamos el array crudo con los 11 campos
        }
        return array();
    }

    public function getByDni($dni)
    {
        // Traemos a todos los estudiantes de la API
        $studentList = $this->getAll();

        // Buscamos en el array el que coincida con el DNI
        foreach($studentList as $studentData)
        {
            if($studentData['dni'] == $dni)
            {
                return $studentData;
            }
        }

        return null;
    }

                   
    public function getById($id) { return null; }
    public function add(Student $student) { return 0; }
    public function getByUserId(int $userId): ?Student { return null; }
}