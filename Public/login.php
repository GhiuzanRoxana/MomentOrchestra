<?php
session_start();
require_once '../config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = clean($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!empty($username) && !empty($password)) {
        $userModel = new User();
        $user = $userModel->login($username, $password);

        if ($user) {
            $_SESSION['user_id'] = $user['id_user'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['full_name'] = $user['full_name'];

            header('Location: index.php');
            exit;
        } else {
            $error = 'Username sau parolă incorecte!';
        }
    } else {
        $error = 'Completează toate câmpurile!';
    }
}

include '../View/login_view.php';
