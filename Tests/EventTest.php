<?php

use PHPUnit\Framework\TestCase;

if (!defined('DB_HOST')) {
    require_once __DIR__ . '/../config.php';
}

class EventTest extends TestCase
{

    private $eventModel;

    protected function setUp(): void
    {
        $this->eventModel = new Event();
    }

    public function testCreateEvent()
    {
        $eventData = [
            'title' => 'Test Concert ' . time(),
            'event_date' => date('Y-m-d H:i:s', strtotime('+1 week')),
            'location_id' => 1,
            'description' => 'Test concert description',
            'status_id' => 1
        ];

        $eventId = $this->eventModel->create($eventData);

        $this->assertNotEmpty($eventId);
        $this->assertStringStartsWith('EVT_', $eventId);
    }

    public function testReadEvent()
    {
        $eventData = [
            'title' => 'Read Test Event ' . time(),
            'event_date' => date('Y-m-d H:i:s', strtotime('+2 weeks')),
            'location_id' => 1,
            'description' => 'Read test description',
            'status_id' => 1
        ];

        $eventId = $this->eventModel->create($eventData);
        $event = $this->eventModel->read($eventId);

        $this->assertNotEmpty($event);
        $this->assertEquals($eventData['title'], $event['title']);
    }

    public function testReadAllEvents()
    {
        $events = $this->eventModel->readAll();

        $this->assertIsArray($events);
    }

    public function testUpdateEvent()
    {
        $eventData = [
            'title' => 'Update Test Event ' . time(),
            'event_date' => date('Y-m-d H:i:s', strtotime('+3 weeks')),
            'location_id' => 1,
            'description' => 'Original description',
            'status_id' => 1
        ];

        $eventId = $this->eventModel->create($eventData);

        $updateData = [
            'title' => 'Updated Event Title',
            'event_date' => $eventData['event_date'],
            'location_id' => 1,
            'description' => 'Updated description',
            'status_id' => 1
        ];

        $result = $this->eventModel->update($eventId, $updateData);

        $this->assertTrue($result);

        $updatedEvent = $this->eventModel->read($eventId);
        $this->assertEquals($updateData['title'], $updatedEvent['title']);
    }

    public function testDeleteEvent()
    {
        $eventData = [
            'title' => 'Delete Test Event ' . time(),
            'event_date' => date('Y-m-d H:i:s', strtotime('+4 weeks')),
            'location_id' => 1,
            'description' => 'To be deleted',
            'status_id' => 1
        ];

        $eventId = $this->eventModel->create($eventData);
        $result = $this->eventModel->delete($eventId);

        $this->assertTrue($result);

        $deletedEvent = $this->eventModel->read($eventId);
        $this->assertFalse($deletedEvent);
    }
}
