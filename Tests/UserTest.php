<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../config.php';

class UserTest extends TestCase
{
    private $userModel;

    protected function setUp(): void
    {
        $this->userModel = new User();
    }

    public function testReadUser()
    {
        $allUsers = $this->userModel->readAll();

        if (empty($allUsers)) {
            $this->markTestSkipped('Nu există useri în DB pentru test');
        }

        $firstUser = $allUsers[0];
        $userId = $firstUser['id_user'];

        $user = $this->userModel->read($userId);

        $this->assertNotEmpty($user);
        $this->assertEquals($userId, $user['id_user']);
        $this->assertEquals($firstUser['username'], $user['username']);
    }

    public function testReadAllUsers()
    {
        $users = $this->userModel->readAll();

        $this->assertIsArray($users);
        $this->assertGreaterThan(0, count($users));

        if (!empty($users)) {
            $this->assertArrayHasKey('id_user', $users[0]);
            $this->assertArrayHasKey('username', $users[0]);
            $this->assertArrayHasKey('email', $users[0]);
        }
    }

    public function testUpdateUser()
    {
        $allUsers = $this->userModel->readAll();

        if (empty($allUsers)) {
            $this->markTestSkipped('Nu există useri în DB pentru test');
        }

        $testUser = $allUsers[0];
        $userId = $testUser['id_user'];
        $originalEmail = $testUser['email'];
        $originalName = $testUser['full_name'];

        $testData = [
            'username' => $testUser['username'],
            'email' => 'newemail_test@test.ro',
            'full_name' => 'Test Updated Name'
        ];

        $result = $this->userModel->update($userId, $testData);
        $this->assertTrue($result);

        $updatedUser = $this->userModel->read($userId);
        $this->assertEquals('newemail_test@test.ro', $updatedUser['email']);
        $this->assertEquals('Test Updated Name', $updatedUser['full_name']);

        $resetData = [
            'username' => $testUser['username'],
            'email' => $originalEmail,
            'full_name' => $originalName
        ];
        $this->userModel->update($userId, $resetData);
    }

    public function testDeleteUser()
    {
        $testData = [
            'username' => 'testuser_' . time(),
            'password' => 'test123',
            'email' => 'test_' . time() . '@test.ro',
            'role' => 'user',
            'full_name' => 'Test User Temporary'
        ];

        $userId = $this->userModel->create($testData);

        $this->assertNotEmpty($userId);
        $this->assertStringStartsWith('USER_', $userId);

        $user = $this->userModel->read($userId);
        $this->assertNotEmpty($user);

        $result = $this->userModel->delete($userId);
        $this->assertTrue($result);

        $deletedUser = $this->userModel->read($userId);
        $this->assertFalse($deletedUser);
    }

    public function testLoginWithValidCredentials()
    {
        $timestamp = time();
        $testUsername = 'logintest_' . $timestamp;
        $testPassword = 'testpass123';

        $testData = [
            'username' => $testUsername,
            'password' => $testPassword,
            'email' => 'logintest_' . $timestamp . '@test.ro',
            'role' => 'user',
            'full_name' => 'Login Test User'
        ];

        $userId = $this->userModel->create($testData);
        $this->assertNotEmpty($userId);

        $user = $this->userModel->login($testUsername, $testPassword);

        $this->assertNotFalse($user);
        $this->assertIsArray($user);
        $this->assertEquals($testUsername, $user['username']);
        $this->assertArrayHasKey('id_user', $user);

        $this->userModel->delete($userId);
    }

    public function testLoginWithInvalidCredentials()
    {
        $user = $this->userModel->login('usercare_nu_exista_niciodata', 'parola_gresita');

        $this->assertFalse($user);
    }

    public function testLoginWithWrongPassword()
    {
        $allUsers = $this->userModel->readAll();

        if (!empty($allUsers)) {
            $existingUsername = $allUsers[0]['username'];
            $user = $this->userModel->login($existingUsername, 'parola_gresita_sigur_1234567890');

            $this->assertFalse($user);
        } else {
            $this->markTestSkipped('Nu există useri în DB pentru test');
        }
    }
}
