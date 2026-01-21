<?php
namespace DAO;

use Models\Student;

class StudentDAOApi implements IStudentDAO
{
    private $apiUrl = API_URL . 'Student';

    public function getAll()
    {
        $response = file_get_contents($this->apiUrl);
        $data = json_decode($response, true);

        $students = [];

        foreach ($data as $value) {
            $student = new Student();
            $student->setStudentId($value['studentId']);
            $student->setCareerId($value['careerId']);
            $student->setFirstName($value['firstName']);
            $student->setLastName($value['lastName']);
            $student->setEmail($value['email']);
            $student->setActive($value['active']);

            $students[] = $student;
        }

        return $students;
    }

    public function getById($id)
    {
        foreach ($this->getAll() as $student) {
            if ($student->getStudentId() == $id) {
                return $student;
            }
        }
        return null;
    }

    public function getByEmail($email)
    {
        foreach ($this->getAll() as $student) {
            if ($student->getEmail() === $email) {
                return $student;
            }
        }
        return null;
    }

    public function add(Student $student)
    {
        // POST a la API
        return true;
    }
}
