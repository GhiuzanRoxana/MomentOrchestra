<?php

use PHPUnit\Framework\TestCase;

if (!defined('DB_HOST')) {
    require_once __DIR__ . '/../config.php';
}

class UserTest extends TestCase
{

    private $userModel;

    protected function setUp(): void
    {
        $this->userModel = new User();
    }

    public function testCreateUser()
    {
        $userData = [
            'username' => 'testuser_' . time(),
            'password' => 'TestPassword123',
            'email' => 'test_' . time() . '@example.com',
            'full_name' => 'Test User',
            'role' => 'user'
        ];

        $userId = $this->userModel->create($userData);

        $this->assertNotEmpty($userId);
        $this->assertStringStartsWith('USER_', $userId);
    }

    public function testReadUser()
    {
        $userData = [
            'username' => 'readtest_' . time(),
            'password' => 'TestPassword123',
            'email' => 'read_' . time() . '@example.com',
            'full_name' => 'Read Test User',
            'role' => 'user'
        ];

        $userId = $this->userModel->create($userData);
        $user = $this->userModel->read($userId);

        $this->assertNotEmpty($user);
        $this->assertEquals($userData['username'], $user['username']);
        $this->assertEquals($userData['email'], $user['email']);
    }

    public function testReadAllUsers()
    {
        $users = $this->userModel->readAll();

        $this->assertIsArray($users);
    }

    public function testUpdateUser()
    {
        $userData = [
            'username' => 'updatetest_' . time(),
            'password' => 'TestPassword123',
            'email' => 'update_' . time() . '@example.com',
            'full_name' => 'Update Test',
            'role' => 'user'
        ];

        $userId = $this->userModel->create($userData);

        $updateData = [
            'username' => $userData['username'],
            'email' => 'updated_' . time() . '@example.com',
            'full_name' => 'Updated Name'
        ];

        $result = $this->userModel->update($userId, $updateData);

        $this->assertTrue($result);

        $updatedUser = $this->userModel->read($userId);
        $this->assertEquals($updateData['full_name'], $updatedUser['full_name']);
    }

    public function testDeleteUser()
    {
        $userData = [
            'username' => 'deletetest_' . time(),
            'password' => 'TestPassword123',
            'email' => 'delete_' . time() . '@example.com',
            'full_name' => 'Delete Test',
            'role' => 'user'
        ];

        $userId = $this->userModel->create($userData);
        $result = $this->userModel->delete($userId);

        $this->assertTrue($result);

        $deletedUser = $this->userModel->read($userId);
        $this->assertFalse($deletedUser);
    }

    public function testLoginWithValidCredentials()
    {
        $password = 'TestPassword123';
        $userData = [
            'username' => 'logintest_' . time(),
            'password' => $password,
            'email' => 'login_' . time() . '@example.com',
            'full_name' => 'Login Test',
            'role' => 'user'
        ];

        $userId = $this->userModel->create($userData);
        $user = $this->userModel->login($userData['username'], $password);

        $this->assertNotFalse($user);
        $this->assertEquals($userData['username'], $user['username']);
    }

    public function testLoginWithInvalidCredentials()
    {
        $user = $this->userModel->login('nonexistent_user', 'wrongpassword');

        $this->assertFalse($user);
    }
}
