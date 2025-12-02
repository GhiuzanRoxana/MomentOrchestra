<?php

class UserController extends BaseController
{

    private $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = new User();
    }

    public function login($username, $password)
    {
        $user = $this->userModel->login($username, $password);

        if ($user) {
            $_SESSION['user_id'] = $user['id_user'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            return ['success' => true, 'redirect' => BASE_URL . 'index.php'];
        }

        return ['success' => false, 'message' => 'Invalid credentials'];
    }

    public function logout()
    {
        session_destroy();
        $this->redirect(BASE_URL . 'login.php');
    }
}
