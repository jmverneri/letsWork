<?php
namespace DAO;

use DAO\IStudentDAO;
use Models\Student;
use Models\Career;

class StudentDAOMock implements IStudentDAO
{
    private array $studentList = [];

    public function __construct()
    {
        /* =====================
           CAREERS MOCK
        ===================== */

        $career1 = new Career();
        $career1->setCareerId(1);
        $career1->setDescription("Computer Science");

        $career2 = new Career();
        $career2->setCareerId(2);
        $career2->setDescription("Business Administration");

        /* =====================
           STUDENT 1
        ===================== */

        $student1 = new Student();
        $student1->setStudentId(1)
                 ->setFirstName("Juan")
                 ->setLastName("Pérez")
                 ->setDni("32444999")
                 ->setEmail("student@test.com")
                 ->setPassword("123")
                 ->setCareer($career1)
                 ->setActive(true);

        /* =====================
           STUDENT 2
        ===================== */

        $student2 = new Student();
        $student2->setStudentId(2)
                 ->setFirstName("Ana")
                 ->setLastName("Gonzalez")
                 ->setDni("45000333")
                 ->setEmail("ana@test.com")
                 ->setPassword("1234")
                 ->setCareer($career2)
                 ->setActive(true);

        $this->studentList[] = $student1;
        $this->studentList[] = $student2;
    }

    /* =====================
       DAO METHODS
    ===================== */

    public function getAll(): array
    {
        return $this->studentList;
    }

    public function getById($id): ?Student
    {
        foreach ($this->studentList as $student) {
            if ($student->getStudentId() == $id) {
                return $student;
            }
        }
        return null;
    }

    public function getByEmail($email): ?Student
    {
        foreach ($this->studentList as $student) {
            if ($student->getEmail() === $email) {
                return $student;
            }
        }
        return null;
    }

    public function add(Student $student)
    {
        // mock success
        return 1;
    }
}
