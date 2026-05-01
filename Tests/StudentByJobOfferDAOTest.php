<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use DAO\StudentByJobOfferDAO;
use DAO\Connection;
use Models\StudentByJobOffer;

class StudentByJobOfferDAOTest extends TestCase {
    private $mockConnection;
    private $dao;

    protected function setUp(): void {
        $this->mockConnection = $this->createMock(Connection::class);
        $this->dao = new StudentByJobOfferDAO($this->mockConnection);
    }

    #[Test]
    public function testGetByJobOfferIdReturnsArray() {
        $fakeResultSet = [
            ["studentXJobOffersId" => 1, "jobOfferId" => 10, "studentId" => 500]
        ];

        // Esperamos exactamente UNA llamada a execute
        $this->mockConnection->expects($this->once())
            ->method('execute')
            ->with($this->stringContains("SELECT"), ["jobOfferId" => 10])
            ->willReturn($fakeResultSet);

        $result = $this->dao->getByJobOfferId(10);

        $this->assertIsArray($result);
        $this->assertCount(1, $result);
        $this->assertEquals(500, $result[0]['studentId']);
    }

    #[Test]
    public function testAddStudentToJobOfferExecutesCorrectly() {
        $this->mockConnection->expects($this->once())
            ->method('executeNonQuery')
            ->with(
                $this->stringContains("INSERT INTO students_x_job_offers"),
                $this->logicalAnd(
                    $this->countOf(2),
                    $this->arrayHasKey('job_offer_id'),
                    $this->arrayHasKey('student_id')
                )
            )
            ->willReturn(1);

        $result = $this->dao->addStudentToAJobOffer(10, 500);
        $this->assertEquals(1, $result);
    }
}