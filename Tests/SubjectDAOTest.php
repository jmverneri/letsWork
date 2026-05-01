<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use DAO\SubjectDAO;
use DAO\Connection;
use Models\Subject;

class SubjectDAOTest extends TestCase {
    private $mockConnection;
    private $dao;

    protected function setUp(): void {
        $this->mockConnection = $this->createMock(Connection::class);
        $this->dao = new SubjectDAO($this->mockConnection);
    }

    #[Test]
    public function testGetByCareerReturnsMappedSubjects() {
        $fakeResultSet = [
            [
                "subjectId" => 1,
                "careerId" => 10,
                "asignatura" => "Metodología de Sistemas I",
                "cursado" => "Cuatrimestral",
                "hsSemanales" => 4,
                "cargaHorariaTotal" => 64,
                "creditos" => 5,
                "active" => 1
            ]
        ];

        $this->mockConnection->expects($this->once())
            ->method('Execute')
            ->willReturn($fakeResultSet);

        $result = $this->dao->getByCareer(10);

        $this->assertIsArray($result);
        $this->assertInstanceOf(Subject::class, $result[0]);
        $this->assertEquals("Metodología de Sistemas I", $result[0]->getAsignatura());
    }

    #[Test]
    public function testGetApprovedByStudentExecutesCorrectJoin() {
        $this->mockConnection->expects($this->once())
            ->method('Execute')
            ->with($this->stringContains("INNER JOIN student_subjects"), ["studentId" => 100])
            ->willReturn([]);

        $this->dao->getApprovedByStudent(100);
    }

    #[Test]
    public function testDeletePerformsLogicalUpdate() {
        $this->mockConnection->expects($this->once())
            ->method('ExecuteNonQuery')
            ->with($this->stringContains("SET active = 0"), ["subjectId" => 1]);

        $this->dao->delete(1);
    }

    #[Test]
    public function testAddApprovedSubjectInsertsRelation() {
        $this->mockConnection->expects($this->once())
            ->method('ExecuteNonQuery')
            ->with($this->stringContains("INSERT INTO student_subjects"), ["studentId" => 1, "subjectId" => 5]);

        $this->dao->addApprovedSubject(1, 5);
    }
}