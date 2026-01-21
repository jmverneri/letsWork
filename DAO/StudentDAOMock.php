<?php
namespace DAO;

use DAO\IStudentDAO;
use Models\Student;

class StudentDAOMock implements IStudentDAO
{
    private $studentList = [];

    /**
     * Devuelve todos los estudiantes
     * (por ahora mock, luego API o BD)
     */
    public function getAll()
    {
        // Ejemplo mock
        $student = new Student();
        $student->setStudentId(1);
        $student->setFirstName("Juan");
        $student->setLastName("Pérez");
        $student->setEmail("juan@mail.com");
        $student->setActive(true);

        $this->studentList[] = $student;

        return $this->studentList;
    }

    /**
     * Busca estudiante por ID
     */
    public function getById($id)
    {
        foreach ($this->getAll() as $student) {
            if ($student->getStudentId() == $id) {
                return $student;
            }
        }
        return null;
    }

    /**
     * Busca estudiante por email
     */
    public function getByEmail($email)
    {
        foreach ($this->getAll() as $student) {
            if ($student->getEmail() === $email) {
                return $student;
            }
        }
        return null;
    }

    /**
     * Agrega estudiante
     */
    public function add(Student $student)
    {
        // más adelante:
        // - insertar en BD
        // - o POST a la API

        // por ahora simulamos éxito
        return 1;
    }
}
