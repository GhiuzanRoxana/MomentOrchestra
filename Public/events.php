<?php
require_once '../config.php';

try {
    $eventController = new EventController();
    $events = $eventController->index();
} catch (Exception $e) {
    $events = [];
    $error = "Eroare la încărcarea evenimentelor.";
}

include '../View/events_list_view.php';
