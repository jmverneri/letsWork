<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use DAO\ApplicationDAO;
use DAO\Connection;

class ApplicationDAOTest extends TestCase {
    private $mockConnection;
    private $dao;

    protected function setUp(): void {
        $this->mockConnection = $this->createMock(Connection::class);
        $this->dao = new ApplicationDAO($this->mockConnection);
    }

    #[Test]
    public function testAddApplicationReturnsOne() {
        $this->mockConnection->expects($this->once())
            ->method('ExecuteNonQuery')
            ->willReturn(1);

        $result = $this->dao->add(1, 10, '2026-05-01');
        $this->assertEquals(1, $result);
    }

    #[Test]
    public function testIsStudentAppliedReturnsTrueWhenFound() {
        // Simulamos que la DB encuentra al estudiante
        $this->mockConnection->expects($this->once())
            ->method('Execute')
            ->willReturn([['studentId' => 1]]);

        $result = $this->dao->isStudentApplied(1, 10);
        $this->assertTrue($result);
    }

    #[Test]
    public function testGetAppliedOfferIdsReturnsSimpleArray() {
        $fakeResultSet = [
            ['jobOfferId' => 101],
            ['jobOfferId' => 105]
        ];

        $this->mockConnection->expects($this->once())
            ->method('Execute')
            ->willReturn($fakeResultSet);

        $result = $this->dao->getAppliedOfferIds(1);

        $this->assertIsArray($result);
        $this->assertEquals([101, 105], $result);
    }

    #[Test]
    public function testCountApplicantsReturnsInteger() {
        $this->mockConnection->expects($this->once())
            ->method('Execute')
            ->willReturn([["total" => 5]]);

        $result = $this->dao->countApplicantsByOffer(10);
        $this->assertEquals(5, $result);
    }
}