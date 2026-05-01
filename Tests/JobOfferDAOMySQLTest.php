<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use DAO\JobOfferDAOMySQL;
use DAO\Connection;
use Models\JobOffer;

class JobOfferDAOMySQLTest extends TestCase {
    private $mockConnection;
    private $dao;

    protected function setUp(): void {
        $this->mockConnection = $this->createMock(Connection::class);
        $this->dao = new JobOfferDAOMySQL($this->mockConnection);
    }

    #[Test]
    public function testGetAllReturnsListWithJoinData() {
        $fakeRow = [
            [
                "jobOfferId" => 1,
                "title" => "Desarrollador PHP",
                "description" => "Busqueda activa",
                "salary" => 50000,
                "startDate" => "2026-01-01",
                "deadline" => "2026-12-31",
                "active" => 1,
                "companyId" => 10,
                "jobPositionId" => 5,
                "flyer_image_path" => "img/offer1.jpg",
                "companyName" => "UTN Software Store",
                "jobPositionDescription" => "Backend Dev"
            ]
        ];

        $this->mockConnection->expects($this->once())
            ->method('Execute')
            ->willReturn($fakeRow);

        $result = $this->dao->GetAll();

        $this->assertIsArray($result);
        $this->assertCount(1, $result);
        $this->assertInstanceOf(JobOffer::class, $result[0]);
        
        // Verificamos que los datos del JOIN se setearon correctamente
        $this->assertEquals("UTN Software Store", $result[0]->getCompanyName());
        $this->assertEquals("Backend Dev", $result[0]->getJobPositionDescription());
    }

    #[Test]
    public function testGetStatsReturnsFormattedArray() {
        $fakeStats = [[
            "active_count" => 5,
            "inactive_count" => 2,
            "total_count" => 7
        ]];

        $this->mockConnection->expects($this->once())
            ->method('Execute')
            ->willReturn($fakeStats);

        $result = $this->dao->GetStats();

        $this->assertIsArray($result);
        $this->assertEquals(5, $result["active_count"]);
        $this->assertEquals(7, $result["total_count"]);
    }

    #[Test]
    public function testAddReturnsLastInsertId() {
        $offer = new JobOffer();
        $offer->setTitle("Nueva Oferta");
        $offer->setActive(true);

        $this->mockConnection->expects($this->once())
            ->method('ExecuteNonQuery');

        $this->mockConnection->expects($this->once())
            ->method('lastInsertId')
            ->willReturn(99);

        $result = $this->dao->add($offer);

        $this->assertEquals(99, $result);
    }
}