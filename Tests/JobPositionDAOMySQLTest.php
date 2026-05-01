<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use DAO\JobPositionDAOMySQL;
use DAO\Connection;
use Models\JobPosition;

class JobPositionDAOMySQLTest extends TestCase {
    private $mockConnection;
    private $dao;

    protected function setUp(): void {
        $this->mockConnection = $this->createMock(Connection::class);
        $this->dao = new JobPositionDAOMySQL($this->mockConnection);
    }

    #[Test]
    public function testGetByIdReturnsPositionModel() {
        $fakeRow = [[
            "jobPositionId" => 1,
            "careerId" => 2,
            "description" => "Junior Java Developer"
        ]];

        $this->mockConnection->expects($this->once())
            ->method('Execute')
            ->willReturn($fakeRow);

        $result = $this->dao->getById(1);

        $this->assertInstanceOf(JobPosition::class, $result);
        $this->assertEquals(1, $result->getJobPositionId());
        $this->assertEquals("Junior Java Developer", $result->getDescription());
    }

    #[Test]
    public function testGetByCareerIdFiltersCorrectly() {
        $fakeResultSet = [
            ["jobPositionId" => 1, "careerId" => 2, "description" => "Dev A"],
            ["jobPositionId" => 5, "careerId" => 2, "description" => "Dev B"]
        ];

        $this->mockConnection->expects($this->once())
            ->method('Execute')
            ->with($this->anything(), ["careerId" => 2])
            ->willReturn($fakeResultSet);

        $result = $this->dao->getByCareerId(2);

        $this->assertIsArray($result);
        $this->assertCount(2, $result);
        $this->assertEquals("Dev B", $result[1]->getDescription());
    }

    #[Test]
    public function testDeleteExecutesUpdateQuery() {
        // En el DAO, delete() hace un UPDATE active = 0
        $this->mockConnection->expects($this->once())
            ->method('ExecuteNonQuery')
            ->with($this->stringContains("UPDATE"), ["id" => 10]);

        $this->dao->delete(10);
    }
}