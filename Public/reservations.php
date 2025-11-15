<?php
require_once '../config.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

try {
    $reservationController = new ReservationController();
    $reservations = $reservationController->myReservations();
} catch (Exception $e) {
    $reservations = [];
    $error = "Eroare la încărcarea rezervărilor.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel'])) {
    $cancelId = $_POST['cancel_id'];
    $result = $reservationController->cancel($cancelId);

    if ($result) {
        header('Location: reservations.php?cancelled=1');
        exit;
    }
}

include '../View/reservations_list_view.php';
