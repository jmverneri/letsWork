<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use DAO\StudentPreferenceDAO;
use DAO\Connection;

class StudentPreferenceDAOTest extends TestCase {
    private $mockConnection;
    private $dao;

    protected function setUp(): void {
        // Usamos el mock para interceptar las llamadas a la DB
        $this->mockConnection = $this->createMock(Connection::class);
        $this->dao = new StudentPreferenceDAO($this->mockConnection);
    }

    #[Test]
    public function testAddPreferenceHandlesArrayOrInt() {
        // Probamos que si le pasas un array (como tenés en el código), tome el primer índice
        $this->mockConnection->expects($this->once())
            ->method('ExecuteNonQuery')
            ->with($this->anything(), ["studentId" => 1, "jobPositionId" => 50])
            ->willReturn(1);

        $result = $this->dao->addPreference(1, [50]); // Pasamos array para probar tu lógica interna
        $this->assertEquals(1, $result);
    }

    #[Test]
    public function testClearPreferencesExecutesDelete() {
        $this->mockConnection->expects($this->once())
            ->method('ExecuteNonQuery')
            ->with($this->stringContains("DELETE FROM student_preferences"), ["studentId" => 1]);

        $this->dao->clearPreferences(1);
    }

    #[Test]
    public function testGetStudentIdsByPositionReturnsResults() {
        $fakeResultSet = [
            ["studentId" => 1],
            ["studentId" => 5]
        ];

        $this->mockConnection->expects($this->once())
            ->method('Execute')
            ->with($this->anything(), ["jobPositionId" => 10])
            ->willReturn($fakeResultSet);

        $result = $this->dao->getStudentIdsByPosition(10);

        $this->assertIsArray($result);
        $this->assertCount(2, $result);
        $this->assertEquals(5, $result[1]['studentId']);
    }
}