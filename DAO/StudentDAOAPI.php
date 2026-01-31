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

    public function getAll() { return array(); }
    public function getById($id) { return null; }
    public function add(Student $student) { return 0; }
    public function getByUserId(int $userId): ?Student { return null; }
}