<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use DAO\InterviewDAO;
use DAO\Connection;
use Models\Interview;

class InterviewDAOTest extends TestCase {
    private $mockConnection;
    private $dao;

    protected function setUp(): void {
        $this->mockConnection = $this->createMock(Connection::class);
        $this->dao = new InterviewDAO($this->mockConnection);
    }

    #[Test]
    public function testAddShouldReturnOneOnSuccess() { // Agregué 'test' al inicio
        $this->mockConnection->expects($this->once())
            ->method('ExecuteNonQuery')
            ->with(
                $this->callback(fn($query) => str_contains($query, "INSERT INTO")),
                $this->callback(fn($params) => is_array($params)) 
            )
            ->willReturn(1);

        $result = $this->dao->add(1, 10, '2026-05-10 15:00:00', 'Virtual Link');
        $this->assertEquals(1, $result);
    }

    #[Test]
    public function testUpdateStatusShouldReturnOneOnSuccess() { // Agregué 'test'
        $this->mockConnection->expects($this->once())
            ->method('ExecuteNonQuery')
            ->with(
                $this->anything(),
                $this->callback(fn($p) => isset($p['status']) && isset($p['interviewId']))
            )
            ->willReturn(1);

        $result = $this->dao->updateStatus(13, 'completed');
        $this->assertEquals(1, $result);
    }

    #[Test]
    public function testGetByIdShouldReturnInterviewModelWhenFound() { // Agregué 'test'
        $fakeRow = [[
            'interviewId' => 100,
            'studentId' => 1,
            'jobOfferId' => 50,
            'date_time' => '2026-06-01',
            'status' => 'scheduled'
        ]];

        $this->mockConnection->expects($this->once())
            ->method('Execute')
            ->with($this->anything(), $this->anything())
            ->willReturn($fakeRow);

        $result = $this->dao->getById(100);

        $this->assertInstanceOf(Interview::class, $result);
        $this->assertEquals(100, $result->getInterviewId());
    }

    #[Test]
    public function testGetInterviewsByCompanyShouldReturnArray() { // Agregué 'test'
        $this->mockConnection->expects($this->once())
            ->method('Execute')
            ->willReturn([['id' => 1], ['id' => 2]]);

        $result = $this->dao->getInterviewsByCompany(5);
        $this->assertCount(2, $result);
    }
}