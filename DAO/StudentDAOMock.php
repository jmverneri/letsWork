<?php
namespace DAO;

use DAO\IStudentDAO;
use Models\Student;

class StudentDAOMock implements IStudentDAO
{
    private $studentList = [];

    public function __construct()
    {
        // Student 1
        $student1 = new Student();
        $student1->setStudentId(1);
        $student1->setFirstName("Juan");
        $student1->setLastName("Pérez");
        $student1->setDni("32444999");
        $student1->setEmail("student@test.com");
        $student1->setPassword("123");
        $student1->setCareerId(1);
        $student1->setActive(true);

        // Student 2
        $student2 = new Student();
        $student2->setStudentId(2);
        $student2->setFirstName("Ana");
        $student2->setLastName("Gonzalez");
        $student2->setDni("45000333");
        $student2->setEmail("ana@test.com");
        $student2->setPassword("1234");
        $student2->setCareerId(2);
        $student2->setActive(true);

        $this->studentList[] = $student1;
        $this->studentList[] = $student2;
    }

    /**
     * Devuelve todos los estudiantes
     * (por ahora mock, luego API o BD)
     */
    public function getAll()
    {
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
