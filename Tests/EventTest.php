<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../config.php';

class EventTest extends TestCase
{
    private $eventModel;
    private $createdEventIds = [];

    protected function setUp(): void
    {
        $this->eventModel = new Event();
        $this->createdEventIds = [];
    }

    protected function tearDown(): void
    {
        foreach ($this->createdEventIds as $eventId) {
            try {
                $this->eventModel->delete($eventId);
            } catch (Exception $e) {
            }
        }
    }

    public function testCreateEvent()
    {
        $eventData = [
            'title' => 'PHPUNIT_CREATE_' . uniqid(),
            'event_date' => date('Y-m-d H:i:s', strtotime('+2 years')),
            'location_id' => 'L1',
            'description' => 'PHPUnit test event',
            'status_id' => 'S1'
        ];

        $eventId = $this->eventModel->create($eventData);
        $this->createdEventIds[] = $eventId;

        $this->assertNotEmpty($eventId);
        $this->assertStringStartsWith('EVT_', $eventId);
    }

    public function testReadEvent()
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->query("SELECT id_event FROM events WHERE id_event NOT LIKE 'EVT_%' LIMIT 1");
        $existingEvent = $stmt->fetch();

        if (!$existingEvent) {
            $this->markTestSkipped('Nu există evenimente permanente în DB');
        }

        $event = $this->eventModel->read($existingEvent['id_event']);

        $this->assertNotEmpty($event);
        $this->assertEquals($existingEvent['id_event'], $event['id_event']);
    }

    public function testReadAllEvents()
    {
        $events = $this->eventModel->readAll();

        $this->assertIsArray($events);
        $this->assertGreaterThan(0, count($events));
    }

    public function testUpdateEvent()
    {
        $eventData = [
            'title' => 'PHPUNIT_ORIGINAL_' . uniqid(),
            'event_date' => date('Y-m-d H:i:s', strtotime('+2 years')),
            'location_id' => 'L1',
            'description' => 'Original description',
            'status_id' => 'S1'
        ];

        $eventId = $this->eventModel->create($eventData);
        $this->createdEventIds[] = $eventId;

        $updateData = [
            'title' => 'PHPUNIT_UPDATED_' . uniqid(),
            'event_date' => $eventData['event_date'],
            'location_id' => 'L1',
            'description' => 'Updated description',
            'status_id' => 'S1'
        ];

        $result = $this->eventModel->update($eventId, $updateData);
        $this->assertTrue($result);

        $updatedEvent = $this->eventModel->read($eventId);
        $this->assertEquals('Updated description', $updatedEvent['description']);
    }

    public function testDeleteEvent()
    {
        $eventData = [
            'title' => 'PHPUNIT_DELETE_' . uniqid(),
            'event_date' => date('Y-m-d H:i:s', strtotime('+2 years')),
            'location_id' => 'L1',
            'description' => 'To be deleted',
            'status_id' => 'S1'
        ];

        $eventId = $this->eventModel->create($eventData);

        $result = $this->eventModel->delete($eventId);
        $this->assertTrue($result);

        $deletedEvent = $this->eventModel->read($eventId);
        $this->assertFalse($deletedEvent);
    }
}
