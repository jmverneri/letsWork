<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use DAO\StudentDAOMySQL;
use DAO\Connection;
use Models\Student;

class StudentDAOMySQLTest extends TestCase {
    private $mockConnection;
    private $dao;

    protected function setUp(): void {
        $this->mockConnection = $this->createMock(Connection::class);
        $this->dao = new StudentDAOMySQL($this->mockConnection);
    }

    #[Test]
    public function testGetByIdReturnsMappedStudent() {
        $fakeRow = [[
            "studentId" => 1,
            "careerId" => 2,
            "firstName" => "Javier",
            "lastName" => "Martinez",
            "dni" => "12345678",
            "fileNumber" => "UTN-001",
            "gender" => "Male",
            "birthDate" => "2000-01-01",
            "phoneNumber" => "555-1234",
            "active" => 1,
            "userId" => 10
        ]];

        $this->mockConnection->expects($this->once())
            ->method('Execute')
            ->willReturn($fakeRow);

        $result = $this->dao->getById(1);

        $this->assertInstanceOf(Student::class, $result);
        $this->assertEquals("Javier", $result->getFirstName());
        $this->assertEquals("Martinez", $result->getLastName());
    }

    #[Test]
    public function testGetByUserIdWithJoinData() {
        // Simulamos la respuesta del INNER JOIN con la tabla users
        $fakeRow = [[
            "studentId" => 1,
            "firstName" => "Javier",
            "lastName" => "Martinez",
            "dni" => "12345678",
            "fileNumber" => "UTN-001",
            "gender" => "Male",
            "birthDate" => "2000-01-01",
            "phoneNumber" => "555-1234",
            "active" => 1,
            "userId" => 10,
            "careerId" => 2,
            "email" => "javier@example.com" // Columna del JOIN
        ]];

        $this->mockConnection->expects($this->once())
            ->method('Execute')
            ->willReturn($fakeRow);

        $result = $this->dao->getByUserId(10);

        $this->assertInstanceOf(Student::class, $result);
        $this->assertEquals(10, $result->getUserId());
    }

    #[Test]
    public function testAddReturnsAffectedRows() {
        $student = new Student();
        // Inicializamos las propiedades que el DAO usa en el INSERT
        $student->setFirstName("Javier");
        $student->setLastName("Martinez");
        $student->setCareerId(1);
        $student->setDni("12345678");
        $student->setFileNumber("UTN-001");
        $student->setGender("Male");
        $student->setBirthDate("2000-01-01");
        $student->setPhoneNumber("123456");
        $student->setActive(true);
        $student->setUserId(10);

        $this->mockConnection->expects($this->once())
            ->method('ExecuteNonQuery')
            ->willReturn(1);

        $result = $this->dao->add($student);

        $this->assertEquals(1, $result);
    }
}