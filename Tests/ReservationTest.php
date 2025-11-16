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
            'location_id' => 1,
            'description' => 'Test event for reservation',
            'status_id' => 1
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

        $eventData = [
            'title' => 'Read Reservation Event ' . time(),
            'event_date' => date('Y-m-d H:i:s', strtotime('+1 month')),
            'location_id' => 1,
            'description' => 'Event for reading reservation',
            'status_id' => 1
        ];
        $eventId = $this->eventModel->create($eventData);

        $reservationData = [
            'id_user' => $userId,
            'id_event' => $eventId,
            'price' => 75.00,
            'status' => 'confirmed'
        ];

        $this->reservationModel->create($reservationData);
        $reservation = $this->reservationModel->read($userId . '_' . $eventId);

        $this->assertNotEmpty($reservation);
        $this->assertEquals($userId, $reservation['id_user']);
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
            'location_id' => 1,
            'description' => 'Event for deleting reservation',
            'status_id' => 1
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
