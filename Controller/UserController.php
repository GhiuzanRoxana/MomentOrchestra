<?php

class UserController extends BaseController
{

    private $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = new User();
    }

    public function register($data)
    {
        try {
            $this->validate($data, [
                'username' => 'required',
                'password' => 'required',
                'email' => 'required',
                'full_name' => 'required'
            ]);

            $cleanData = [
                'username' => $this->sanitize($data['username']),
                'password' => $data['password'],
                'email' => $this->sanitize($data['email']),
                'full_name' => $this->sanitize($data['full_name']),
                'role' => 'user'
            ];

            $userId = $this->userModel->create($cleanData);
            return ['success' => true, 'user_id' => $userId];
        } catch (ValidationException $e) {
            return ['success' => false, 'errors' => json_decode($e->getMessage(), true)];
        }
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
