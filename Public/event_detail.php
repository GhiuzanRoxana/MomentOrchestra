<?php
require_once '../config.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$eventId = $_GET['id'] ?? '';
$eventModel = new Event();
$event = $eventModel->read($eventId);

if (!$event) {
    header('Location: events.php');
    exit;
}

$success = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $eventType = clean($_POST['event_type'] ?? '');
    $location = clean($_POST['location'] ?? '');
    $eventTime = clean($_POST['event_time'] ?? '');
    $price = clean($_POST['price'] ?? '0');
    $guests = clean($_POST['guests'] ?? '');
    $details = clean($_POST['details'] ?? '');

    if (!empty($eventType) && !empty($location) && !empty($eventTime) && !empty($details)) {
        if ($price < 1000) {
            $error = 'Avansul minim este de 1000 RON!';
        } else {
            try {
                $fullDetails = "Tip: $eventType\n";
                $fullDetails .= "Locație: $location\n";
                $fullDetails .= "Ora: $eventTime\n";
                if (!empty($guests)) {
                    $fullDetails .= "Invitați: $guests\n";
                }
                $fullDetails .= "\nDetalii:\n$details";

                $db = Database::getInstance()->getConnection();
                $stmt = $db->prepare("INSERT INTO reservations (id_user, id_event, price, status, event_type, details) VALUES (?, ?, ?, 'In asteptare', ?, ?)");
                $stmt->execute([$_SESSION['user_id'], $eventId, $price, $eventType, $fullDetails]);

                $success = true;
            } catch (Exception $e) {
                $error = 'Eroare la trimiterea cererii!';
            }
        }
    } else {
        $error = 'Completează toate câmpurile obligatorii!';
    }
}

include '../View/event_detail_view.php';
