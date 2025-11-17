<?php
require_once '../config.php';

$eventModel = new Event();
$allEvents = $eventModel->readAll();

$db = Database::getInstance()->getConnection();
$events = [];

foreach ($allEvents as $event) {
    $stmt = $db->prepare("SELECT status FROM reservations WHERE id_event = ? AND status = 'Confirmata'");
    $stmt->execute([$event['id_event']]);
    $confirmed = $stmt->fetch();

    if (!$confirmed) {
        $events[] = $event;
    }
}

include '../View/events_list_view.php';
