<?php

use PHPUnit\Framework\TestCase;

if (!defined('DB_HOST')) {
    require_once __DIR__ . '/../config.php';
}

class ReservationTest extends TestCase
{

    private $reservationModel;
    private $userModel;
    private $eventModel;

    protected function setUp(): void
    {
        $this->reservationModel = new Reservation();
        $this->userModel = new User();
        $this->eventModel = new Event();
    }

    public function testCreateReservation()
    {
        $userData = [
            'username' => 'restest_' . time(),
            'password' => 'TestPass123',
            'email' => 'restest_' . time() . '@example.com',
            'full_name' => 'Reservation Test User',
            'role' => 'user'
        ];
        $userId = $this->userModel->create($userData);

        $eventData = [
            'title' => 'Reservation Test Event ' . time(),
            'event_date' => date('Y-m-d H:i:s', strtotime('+1 month')),
            'location_id' => 'L1',
            'description' => 'Test event for reservation',
            'status_id' => 'S1'
        ];
        $eventId = $this->eventModel->create($eventData);

        $reservationData = [
            'id_user' => $userId,
            'id_event' => $eventId,
            'price' => 50.00,
            'status' => 'confirmed'
        ];

        $result = $this->reservationModel->create($reservationData);

        $this->assertTrue($result);
    }

    public function testReadReservation()
    {
        $userData = [
            'username' => 'readres_' . time(),
            'password' => 'TestPass123',
            'email' => 'readres_' . time() . '@example.com',
            'full_name' => 'Read Reservation User',
            'role' => 'user'
        ];
        $userId = $this->userModel->create($userData);
        $this->assertNotEmpty($userId, 'User should be created');

        $eventData = [
            'title' => 'Read Reservation Event ' . time(),
            'event_date' => date('Y-m-d H:i:s', strtotime('+1 month')),
            'location_id' => 'L1',
            'description' => 'Event for reading reservation',
            'status_id' => 'S1'
        ];
        $eventId = $this->eventModel->create($eventData);
        $this->assertNotEmpty($eventId, 'Event should be created');

        $reservationData = [
            'id_user' => $userId,
            'id_event' => $eventId,
            'price' => 75.00,
            'status' => 'confirmed'
        ];

        $createResult = $this->reservationModel->create($reservationData);
        $this->assertTrue($createResult, 'Reservation should be created');

        $allReservations = $this->reservationModel->readAll();
        $this->assertGreaterThan(0, count($allReservations), 'Should have at least one reservation');

        $compositeId = $userId . '_' . $eventId;
        $reservation = $this->reservationModel->read($compositeId);

        if ($reservation === false) {
            $this->fail("Failed to read reservation with ID: {$compositeId}. User: {$userId}, Event: {$eventId}");
        }

        $this->assertIsArray($reservation, 'Reservation should be returned as array');
        $this->assertEquals($userId, $reservation['id_user']);
        $this->assertEquals($eventId, $reservation['id_event']);
    }

    public function testReadAllReservations()
    {
        $reservations = $this->reservationModel->readAll();

        $this->assertIsArray($reservations);
    }

    public function testDeleteReservation()
    {
        $userData = [
            'username' => 'delres_' . time(),
            'password' => 'TestPass123',
            'email' => 'delres_' . time() . '@example.com',
            'full_name' => 'Delete Reservation User',
            'role' => 'user'
        ];
        $userId = $this->userModel->create($userData);

        $eventData = [
            'title' => 'Delete Reservation Event ' . time(),
            'event_date' => date('Y-m-d H:i:s', strtotime('+1 month')),
            'location_id' => 'L1',
            'description' => 'Event for deleting reservation',
            'status_id' => 'S1'
        ];
        $eventId = $this->eventModel->create($eventData);

        $reservationData = [
            'id_user' => $userId,
            'id_event' => $eventId,
            'price' => 100.00,
            'status' => 'confirmed'
        ];

        $this->reservationModel->create($reservationData);
        $result = $this->reservationModel->delete($userId . '_' . $eventId);

        $this->assertTrue($result);
    }
}
