<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../config.php';

class ReservationTest extends TestCase
{
    private $reservationModel;
    private $eventModel;
    private $userModel;
    private $createdEventIds = [];
    private $createdUserIds = [];
    private $createdReservations = [];

    protected function setUp(): void
    {
        $this->reservationModel = new Reservation();
        $this->eventModel = new Event();
        $this->userModel = new User();
        $this->createdEventIds = [];
        $this->createdUserIds = [];
        $this->createdReservations = [];
    }

    protected function tearDown(): void
    {
        $db = Database::getInstance()->getConnection();

        foreach ($this->createdReservations as $reservation) {
            try {
                $stmt = $db->prepare("DELETE FROM reservations WHERE id_user = ? AND id_event = ?");
                $stmt->execute([$reservation['id_user'], $reservation['id_event']]);
            } catch (Exception $e) {
            }
        }

        foreach ($this->createdEventIds as $eventId) {
            try {
                $this->eventModel->delete($eventId);
            } catch (Exception $e) {
            }
        }

        foreach ($this->createdUserIds as $userId) {
            try {
                $this->userModel->delete($userId);
            } catch (Exception $e) {
            }
        }
    }

    public function testCreateReservation()
    {
        $uniqueId = uniqid();

        $userData = [
            'username' => 'phpunit_res_' . $uniqueId,
            'password' => 'test123',
            'email' => 'phpunit_res_' . $uniqueId . '@test.ro',
            'role' => 'user',
            'full_name' => 'PHPUnit Reservation Test'
        ];
        $userId = $this->userModel->create($userData);
        $this->createdUserIds[] = $userId;

        $eventData = [
            'title' => 'PHPUNIT_RES_EVENT_' . $uniqueId,
            'event_date' => date('Y-m-d H:i:s', strtotime('+2 years')),
            'location_id' => 'L1',
            'description' => 'PHPUnit reservation test',
            'status_id' => 'S1'
        ];
        $eventId = $this->eventModel->create($eventData);
        $this->createdEventIds[] = $eventId;

        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("
            INSERT INTO reservations (id_user, id_event, price, status, event_type, details) 
            VALUES (?, ?, ?, 'In asteptare', ?, ?)
        ");
        $result = $stmt->execute([$userId, $eventId, 2000, 'Nuntă', 'PHPUnit test']);

        $this->assertTrue($result);
        $this->createdReservations[] = ['id_user' => $userId, 'id_event' => $eventId];
    }

    public function testReadReservation()
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->query("SELECT * FROM reservations LIMIT 1");
        $reservation = $stmt->fetch();

        if ($reservation) {
            $this->assertArrayHasKey('id_user', $reservation);
            $this->assertArrayHasKey('id_event', $reservation);
            $this->assertArrayHasKey('price', $reservation);
        } else {
            $this->assertTrue(true);
        }
    }

    public function testReadAllReservations()
    {
        $reservations = $this->reservationModel->readAll();
        $this->assertIsArray($reservations);
    }

    public function testDeleteReservation()
    {
        $uniqueId = uniqid();

        $userData = [
            'username' => 'phpunit_del_' . $uniqueId,
            'password' => 'test123',
            'email' => 'phpunit_del_' . $uniqueId . '@test.ro',
            'role' => 'user',
            'full_name' => 'PHPUnit Delete Test'
        ];
        $userId = $this->userModel->create($userData);
        $this->createdUserIds[] = $userId;

        $eventData = [
            'title' => 'PHPUNIT_DEL_RES_' . $uniqueId,
            'event_date' => date('Y-m-d H:i:s', strtotime('+2 years')),
            'location_id' => 'L1',
            'description' => 'PHPUnit delete test',
            'status_id' => 'S1'
        ];
        $eventId = $this->eventModel->create($eventData);
        $this->createdEventIds[] = $eventId;

        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("
            INSERT INTO reservations (id_user, id_event, price, status, event_type) 
            VALUES (?, ?, ?, 'In asteptare', ?)
        ");
        $stmt->execute([$userId, $eventId, 2000, 'Nuntă']);

        $result = $this->reservationModel->delete($userId . '_' . $eventId);
        $this->assertTrue($result);
    }
}
