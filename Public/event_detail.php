<?php
require_once '../config.php';

$eventId = $_GET['id'] ?? null;

if (!$eventId) {
    header('Location: events.php');
    exit;
}

try {
    $eventController = new EventController();
    $event = $eventController->show($eventId);

    if (!$event) {
        header('Location: events.php');
        exit;
    }
} catch (Exception $e) {
    header('Location: events.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isLoggedIn()) {
    $reservationController = new ReservationController();
    $result = $reservationController->create([
        'id_event' => $eventId,
        'price' => $_POST['price'] ?? 0
    ]);

    if ($result['success']) {
        $success = "Rezervare realizată cu succes!";
    } else {
        $error = "Eroare la rezervare.";
    }
}

include '../View/event_detail_view.php';
