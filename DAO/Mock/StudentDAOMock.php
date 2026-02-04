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
           STUDENT 1
        ===================== */

        $student1 = new Student();
        $student1->setStudentId(1)
                ->setUserId(2)
                 ->setFirstName("Juan")
                 ->setLastName("Pérez")
                 ->setDni("32444999")
                 ->setCareerId(1)
                 ->setActive(true);

        /* =====================
           STUDENT 2
        ===================== */

        $student2 = new Student();
        $student2->setStudentId(2)
                ->setUserId(3)
                 ->setFirstName("Ana")
                 ->setLastName("Gonzalez")
                 ->setDni("45000333")
                 ->setCareerId(2)
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

    public function getByUserId(int $userId): ?Student
    {
        foreach ($this->studentList as $student) {
            if ($student->getUserId() === $userId) {
                return $student;
            }
        }
        return null;
    }

}
