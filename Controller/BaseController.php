<?php

class BaseController
{

    protected $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
        $this->checkSession();
    }

    protected function checkSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    protected function isLoggedIn()
    {
        return isset($_SESSION['user_id']);
    }

    protected function isAdmin()
    {
        return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    }

    protected function requireLogin()
    {
        if (!$this->isLoggedIn()) {
            header('Location: ' . BASE_URL . 'login.php');
            exit;
        }
    }

    protected function requireAdmin()
    {
        if (!$this->isAdmin()) {
            die('Access denied. Admin only.');
        }
    }

    protected function sanitize($data)
    {
        return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
    }

    protected function validate($data, $rules)
    {
        $errors = [];

        foreach ($rules as $field => $rule) {
            if ($rule === 'required' && empty($data[$field])) {
                $errors[$field] = ucfirst($field) . ' is required';
            }
        }

        if (!empty($errors)) {
            throw new ValidationException(json_encode($errors));
        }

        return true;
    }

    protected function redirect($url)
    {
        header("Location: $url");
        exit;
    }
}
