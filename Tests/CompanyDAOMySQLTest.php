<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use DAO\CompanyDAOMySQL;
use DAO\Connection;
use Models\Company;

class CompanyDAOMySQLTest extends TestCase {
    private $mockConnection;
    private $dao;

    protected function setUp(): void {
        $this->mockConnection = $this->createMock(Connection::class);
        $this->dao = new CompanyDAOMySQL($this->mockConnection);
    }

    #[Test]
    public function testGetByCuitReturnsMappedCompany() {
        $fakeRow = [[
            "companyId" => 1,
            "userId" => 10,
            "name" => "Empresa Test",
            "cuit" => "20-12345678-9",
            "city" => "Mar del Plata",
            "description" => "Software Factory",
            "phoneNumber" => "2234567890",
            "active" => 1
        ]];

        $this->mockConnection->expects($this->once())
            ->method('execute')
            ->willReturn($fakeRow);

        $result = $this->dao->getByCuit("20-12345678-9");

        $this->assertInstanceOf(Company::class, $result);
        $this->assertEquals("Empresa Test", $result->getName());
        $this->assertEquals("20-12345678-9", $result->getCuit());
    }

    #[Test]
    public function testGetByIdReturnsNullWhenNotFound() {
        $this->mockConnection->expects($this->once())
            ->method('execute')
            ->willReturn([]); // Array vacío = No hay resultados

        $result = $this->dao->getById(999);
        $this->assertNull($result);
    }
}