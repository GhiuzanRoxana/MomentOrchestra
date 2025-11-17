<?php
require_once '../config.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

// ADMIN vede panoul de administrare
if (isAdmin()) {
    $db = Database::getInstance()->getConnection();

    // Handle actions
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';
        $userId = $_POST['id_user'] ?? '';
        $eventId = $_POST['id_event'] ?? '';

        if ($action === 'confirm') {
            $stmt = $db->prepare("UPDATE reservations SET status = 'Confirmata' WHERE id_user = ? AND id_event = ?");
            $stmt->execute([$userId, $eventId]);
            $success = "Rezervare confirmată!";
        } elseif ($action === 'cancel') {
            $stmt = $db->prepare("DELETE FROM reservations WHERE id_user = ? AND id_event = ?");
            $stmt->execute([$userId, $eventId]);
            $success = "Rezervare anulată! Data este din nou disponibilă.";
        }
    }

    // Get pending reservations
    $query = "SELECT 
        r.id_user,
        r.id_event,
        r.price,
        r.status,
        r.event_type,
        r.details,
        r.reservation_date,
        e.title as event_title,
        e.event_date,
        u.full_name,
        u.email,
        u.username
    FROM reservations r
    JOIN events e ON r.id_event = e.id_event
    JOIN users u ON r.id_user = u.id_user
    WHERE r.status = 'In asteptare'
    ORDER BY r.reservation_date DESC";

    $pendingReservations = $db->query($query)->fetchAll();

    // Get confirmed reservations
    $query2 = "SELECT 
        r.id_user,
        r.id_event,
        r.price,
        r.status,
        r.event_type,
        r.details,
        r.reservation_date,
        e.title as event_title,
        e.event_date,
        u.full_name,
        u.email
    FROM reservations r
    JOIN events e ON r.id_event = e.id_event
    JOIN users u ON r.id_user = u.id_user
    WHERE r.status = 'Confirmata'
    ORDER BY e.event_date ASC";

    $confirmedReservations = $db->query($query2)->fetchAll();

    include '../View/admin_reservations_view.php';
} else {
    // USER NORMAL vede rezervările lui
    $reservationModel = new Reservation();
    $reservations = $reservationModel->getByUser($_SESSION['user_id']);
    include '../View/reservations_list_view.php';
}
