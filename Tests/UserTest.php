<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../config.php';

class UserTest extends TestCase
{
    private $userModel;
    private $createdUserIds = [];

    protected function setUp(): void
    {
        $this->userModel = new User();
        $this->createdUserIds = [];
    }

    protected function tearDown(): void
    {
        foreach ($this->createdUserIds as $userId) {
            try {
                $this->userModel->delete($userId);
            } catch (Exception $e) {
            }
        }
    }

    public function testReadUser()
    {
        $allUsers = $this->userModel->readAll();

        if (empty($allUsers)) {
            $this->markTestSkipped('Nu există useri în DB');
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
            $this->markTestSkipped('Nu există useri în DB');
        }

        $testUser = $allUsers[0];
        $userId = $testUser['id_user'];
        $originalEmail = $testUser['email'];
        $originalName = $testUser['full_name'];

        $testData = [
            'username' => $testUser['username'],
            'email' => 'phpunit_temp@test.ro',
            'full_name' => 'PHPUnit Temp Name'
        ];

        $result = $this->userModel->update($userId, $testData);
        $this->assertTrue($result);

        $updatedUser = $this->userModel->read($userId);
        $this->assertEquals('phpunit_temp@test.ro', $updatedUser['email']);
        $this->assertEquals('PHPUnit Temp Name', $updatedUser['full_name']);

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
            'username' => 'phpunit_delete_' . uniqid(),
            'password' => 'test123',
            'email' => 'phpunit_delete_' . uniqid() . '@test.ro',
            'role' => 'user',
            'full_name' => 'PHPUnit Delete Test'
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
        $uniqueId = uniqid();
        $testUsername = 'phpunit_login_' . $uniqueId;
        $testPassword = 'test123';

        $testData = [
            'username' => $testUsername,
            'password' => $testPassword,
            'email' => 'phpunit_login_' . $uniqueId . '@test.ro',
            'role' => 'user',
            'full_name' => 'PHPUnit Login Test'
        ];

        $userId = $this->userModel->create($testData);
        $this->createdUserIds[] = $userId;
        $this->assertNotEmpty($userId);

        $user = $this->userModel->login($testUsername, $testPassword);

        $this->assertNotFalse($user);
        $this->assertIsArray($user);
        $this->assertEquals($testUsername, $user['username']);
        $this->assertArrayHasKey('id_user', $user);
    }

    public function testLoginWithInvalidCredentials()
    {
        $user = $this->userModel->login('phpunit_nonexistent_' . uniqid(), 'wrong_password');

        $this->assertFalse($user);
    }

    public function testLoginWithWrongPassword()
    {
        $allUsers = $this->userModel->readAll();

        if (!empty($allUsers)) {
            $existingUsername = $allUsers[0]['username'];
            $user = $this->userModel->login($existingUsername, 'phpunit_wrong_pass_' . uniqid());

            $this->assertFalse($user);
        } else {
            $this->markTestSkipped('Nu există useri în DB');
        }
    }
}
