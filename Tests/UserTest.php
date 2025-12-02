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

    public function testReadUser()
    {
        $user = $this->userModel->read('U1');

        $this->assertNotEmpty($user);
        $this->assertEquals('admin', $user['username']);
        $this->assertEquals('admin@orchestra.ro', $user['email']);
    }

    public function testReadAllUsers()
    {
        $users = $this->userModel->readAll();

        $this->assertIsArray($users);
        $this->assertGreaterThan(0, count($users), 'Should have at least one user');
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

        $this->userModel->delete($userId);
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
        $user = $this->userModel->login('admin', 'admin123');

        $this->assertNotFalse($user);
        $this->assertEquals('admin', $user['username']);
        $this->assertEquals('sef_orchestra', $user['role']);
    }

    public function testLoginWithInvalidCredentials()
    {
        $user = $this->userModel->login('nonexistent_user', 'wrongpassword');

        $this->assertFalse($user);
    }

    public function testLoginWithWrongPassword()
    {
        $user = $this->userModel->login('admin', 'wrongpassword');

        $this->assertFalse($user);
    }
}
