<?php
require_once '../config.php';

try {
    $eventController = new EventController();
    $events = $eventController->index();
    $upcomingEvents = array_slice($events, 0, 3);
} catch (Exception $e) {
    $upcomingEvents = [];
}

include '../View/home_view.php';
