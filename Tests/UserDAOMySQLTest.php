<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use DAO\UserDAOMySQL;
use DAO\Connection;
use Models\User;

class UserDAOMySQLTest extends TestCase {
    private $mockConnection;
    private $dao;

    protected function setUp(): void {
        $this->mockConnection = $this->createMock(Connection::class);
        $this->dao = new UserDAOMySQL($this->mockConnection);
    }

    #[Test]
    public function testAddReturnsLastInsertId() {
        $user = new User();
        $user->setEmail("test@utn.com");
        $user->setPassword("hash123");
        $user->setRole("student");
        $user->setActive(true);

        // Cambiamos 'exactly(2)' por 'once()' porque tu código solo hace un INSERT
        $this->mockConnection->expects($this->once())
            ->method('ExecuteNonQuery')
            ->with($this->stringContains("INSERT INTO users"));

        // El segundo paso de tu función add es un SELECT LAST_INSERT_ID()
        $this->mockConnection->expects($this->once())
            ->method('Execute')
            ->with($this->stringContains("SELECT LAST_INSERT_ID"))
            ->willReturn([["id" => 50]]);

        $result = $this->dao->add($user);

        $this->assertEquals(50, $result);
    }

    #[Test]
    public function testGetByEmailReturnsMappedUser() {
        $fakeRow = [[
            "userId" => 1,
            "email" => "javier@utn.com",
            "password" => "passwordhash",
            "role" => "student",
            "active" => 1
        ]];

        $this->mockConnection->expects($this->once())
            ->method('Execute')
            ->willReturn($fakeRow);

        $result = $this->dao->getByEmail("javier@utn.com");

        $this->assertInstanceOf(User::class, $result);
        $this->assertEquals("javier@utn.com", $result->getEmail());
        $this->assertTrue($result->getActive());
    }
}