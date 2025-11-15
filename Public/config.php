<?php

/**
 * CONFIG.PHP - Configurare bază de date și funcții esențiale
 * TESTEAZĂ PRIMUL - Verifică conexiunea PostgreSQL
 */

// Pornire sesiune
session_start();

// Configurare PostgreSQL
define('DB_HOST', 'localhost');
define('DB_PORT', '5432');
define('DB_NAME', 'moment_orchestra');
define('DB_USER', 'postgres');
define('DB_PASS', ''); // ← PUNE PAROLA TA AICI

/**
 * Obține conexiune PostgreSQL
 * @return PDO
 */
function getDB()
{
    static $pdo = null;

    if ($pdo === null) {
        try {
            $dsn = "pgsql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME;
            $pdo = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        } catch (PDOException $e) {
            die("Eroare conexiune: " . $e->getMessage());
        }
    }

    return $pdo;
}

/**
 * Verifică dacă user e logat
 */
function isLoggedIn()
{
    return isset($_SESSION['user_id']);
}

/**
 * Verifică dacă user e admin
 */
function isAdmin()
{
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

/**
 * Sanitizare input (protecție XSS)
 */
function clean($data)
{
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

/**
 * Redirect
 */
function redirect($url)
{
    header("Location: $url");
    exit;
}
