<?php

class Security
{

    public static function generateCSRFToken()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        return $_SESSION['csrf_token'];
    }

    public static function validateCSRFToken($token)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['csrf_token'])) {
            return false;
        }

        return hash_equals($_SESSION['csrf_token'], $token);
    }

    public static function sanitizeInput($data)
    {
        if (is_array($data)) {
            return array_map([self::class, 'sanitizeInput'], $data);
        }

        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');

        return $data;
    }

    public static function preventXSS($data)
    {
        return htmlspecialchars($data, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    public static function validateEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public static function verifyPassword($password, $hash)
    {
        return password_verify($password, $hash);
    }

    public static function sanitizeFilename($filename)
    {
        $filename = preg_replace('/[^a-zA-Z0-9._-]/', '', $filename);
        return $filename;
    }

    public static function isValidFileType($filename, $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'])
    {
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        return in_array($extension, $allowedTypes);
    }

    public static function preventSQLInjection($data, $pdo)
    {
        if (is_array($data)) {
            return array_map(function ($item) use ($pdo) {
                return self::preventSQLInjection($item, $pdo);
            }, $data);
        }

        return $pdo->quote($data);
    }

    public static function validateURL($url)
    {
        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    }

    public static function rateLimitCheck($identifier, $maxAttempts = 5, $timeWindow = 300)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $key = 'rate_limit_' . $identifier;

        if (!isset($_SESSION[$key])) {
            $_SESSION[$key] = [
                'count' => 1,
                'first_attempt' => time()
            ];
            return true;
        }

        $elapsed = time() - $_SESSION[$key]['first_attempt'];

        if ($elapsed > $timeWindow) {
            $_SESSION[$key] = [
                'count' => 1,
                'first_attempt' => time()
            ];
            return true;
        }

        if ($_SESSION[$key]['count'] >= $maxAttempts) {
            return false;
        }

        $_SESSION[$key]['count']++;
        return true;
    }
}
