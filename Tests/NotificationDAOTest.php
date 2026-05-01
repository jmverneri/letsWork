<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use DAO\NotificationDAO;
use DAO\Connection;
use Models\Notification;

class NotificationDAOTest extends TestCase {
    private $mockConnection;
    private $dao;

    protected function setUp(): void {
        $this->mockConnection = $this->createMock(Connection::class);
        $this->dao = new NotificationDAO($this->mockConnection);
    }

    #[Test]
    public function testGetUnreadByStudentReturnsMappedObjects() {
        $fakeResultSet = [
            [
                "notificationId" => 1,
                "studentId" => 100,
                "jobOfferId" => 50,
                "message" => "Tu postulación fue recibida",
                "is_read" => 0
            ]
        ];

        $this->mockConnection->expects($this->once())
            ->method('Execute')
            ->willReturn($fakeResultSet);

        $result = $this->dao->getUnreadByStudent(100);

        $this->assertIsArray($result);
        $this->assertCount(1, $result);
        $this->assertInstanceOf(Notification::class, $result[0]);
        $this->assertEquals("Tu postulación fue recibida", $result[0]->getMessage());
        $this->assertEquals(0, $result[0]->getIsRead());
    }

   #[Test]
    public function testMarkAsReadExecutesCorrectQuery() {
        $this->mockConnection->expects($this->once())
            ->method('ExecuteNonQuery')
            ->with(
                $this->logicalAnd(
                    $this->stringContains("UPDATE"),
                    $this->stringContains("notifications"),
                    $this->stringContains("is_read = 1")
                ),
                $this->callback(function($params) {
                    return $params['studentId'] === 100 && $params['jobOfferId'] === 50;
                })
            );

        $this->dao->markAsRead(100, 50);
    }

    #[Test]
    public function testCreateInsertsNotification() {
        $this->mockConnection->expects($this->once())
            ->method('ExecuteNonQuery')
            ->with($this->stringContains("INSERT INTO notifications"));

        $this->dao->create(100, 50, "Mensaje de prueba");
    }
}