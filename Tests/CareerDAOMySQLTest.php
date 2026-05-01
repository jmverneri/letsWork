<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use DAO\CareerDAOMySQL;
use DAO\Connection;
use Models\Career;

class CareerDAOMySQLTest extends TestCase {
    private $mockConnection;
    private $dao;

    protected function setUp(): void {
        $this->mockConnection = $this->createMock(Connection::class);
        $this->dao = new CareerDAOMySQL($this->mockConnection);
    }

    #[Test]
    public function testGetByIdReturnsCareerModel() {
        $fakeRow = [[
            "careerId" => 1,
            "description" => "Tecnicatura en Programación",
            "active" => 1
        ]];

        $this->mockConnection->expects($this->once())
            ->method('Execute')
            ->willReturn($fakeRow);

        $result = $this->dao->getById(1);

        $this->assertInstanceOf(Career::class, $result);
        $this->assertEquals(1, $result->getCareerId());
        $this->assertEquals("Tecnicatura en Programación", $result->getDescription());
    }

    #[Test]
    public function testGetAllReturnsArrayOfCareers() {
        $fakeResultSet = [
            ["careerId" => 1, "description" => "Sistemas", "active" => 1],
            ["careerId" => 2, "description" => "Diseño", "active" => 1]
        ];

        $this->mockConnection->expects($this->once())
            ->method('Execute')
            ->willReturn($fakeResultSet);

        $result = $this->dao->getAll();

        $this->assertIsArray($result);
        $this->assertCount(2, $result);
        $this->assertInstanceOf(Career::class, $result[0]);
    }

    #[Test]
    public function testAddFromApiReturnsAffectedRows() {
        $career = new Career();
        $career->setCareerId(5);
        $career->setDescription("Nueva Carrera");
        $career->setActive(true);

        $this->mockConnection->expects($this->once())
            ->method('ExecuteNonQuery')
            ->willReturn(1);

        $result = $this->dao->addFromApi($career);
        $this->assertEquals(1, $result);
    }
}