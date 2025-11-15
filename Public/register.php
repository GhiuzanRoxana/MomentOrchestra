<?php
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userController = new UserController();
    $result = $userController->register($_POST);

    if ($result['success']) {
        header('Location: login.php?registered=1');
        exit;
    } else {
        $errors = $result['errors'] ?? ['general' => 'Eroare la înregistrare'];
    }
}

include '../View/register_view.php';
