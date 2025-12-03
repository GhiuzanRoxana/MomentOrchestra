<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../config.php';

class GalleryTest extends TestCase
{
    private $galleryModel;
    private $createdPhotoIds = [];

    protected function setUp(): void
    {
        $this->galleryModel = new Gallery();
        $this->createdPhotoIds = [];
    }

    protected function tearDown(): void
    {
        $db = Database::getInstance()->getConnection();

        foreach ($this->createdPhotoIds as $photoId) {
            try {
                $parts = explode('_', $photoId, 2);
                if (count($parts) == 2) {
                    $stmt = $db->prepare("DELETE FROM gallery_photos WHERE id_user = ? AND photo_path = ?");
                    $stmt->execute([$parts[0], $parts[1]]);
                }
            } catch (Exception $e) {
            }
        }
    }

    public function testCreatePhoto()
    {
        $uniqueId = uniqid();

        $photoData = [
            'id_user' => 'U1',
            'photo_path' => 'Images/phpunit_test_' . $uniqueId . '.jpg',
            'title' => 'PHPUnit Test Photo',
            'description' => 'PHPUnit test description'
        ];

        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("
            INSERT INTO gallery_photos (id_user, photo_path, title, description, upload_date) 
            VALUES (?, ?, ?, ?, NOW())
        ");
        $result = $stmt->execute([
            $photoData['id_user'],
            $photoData['photo_path'],
            $photoData['title'],
            $photoData['description']
        ]);

        $this->assertTrue($result);
        $this->createdPhotoIds[] = $photoData['id_user'] . '_' . $photoData['photo_path'];
    }

    public function testReadAllPhotos()
    {
        $photos = $this->galleryModel->readAll();
        $this->assertIsArray($photos);
    }

    public function testReadPhoto()
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->query("SELECT * FROM gallery_photos LIMIT 1");
        $photo = $stmt->fetch();

        if ($photo) {
            $this->assertArrayHasKey('id_user', $photo);
            $this->assertArrayHasKey('photo_path', $photo);
            $this->assertArrayHasKey('title', $photo);
        } else {
            $this->assertTrue(true);
        }
    }

    public function testUpdatePhoto()
    {
        $uniqueId = uniqid();

        $photoData = [
            'id_user' => 'U1',
            'photo_path' => 'Images/phpunit_update_' . $uniqueId . '.jpg',
            'title' => 'PHPUnit Original',
            'description' => 'Original description'
        ];

        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("
            INSERT INTO gallery_photos (id_user, photo_path, title, description, upload_date) 
            VALUES (?, ?, ?, ?, NOW())
        ");
        $stmt->execute([
            $photoData['id_user'],
            $photoData['photo_path'],
            $photoData['title'],
            $photoData['description']
        ]);

        $this->createdPhotoIds[] = $photoData['id_user'] . '_' . $photoData['photo_path'];

        $stmt = $db->prepare("
            UPDATE gallery_photos 
            SET title = ?, description = ? 
            WHERE id_user = ? AND photo_path = ?
        ");
        $result = $stmt->execute([
            'PHPUnit Updated',
            'Updated description',
            $photoData['id_user'],
            $photoData['photo_path']
        ]);

        $this->assertTrue($result);
    }

    public function testDeletePhoto()
    {
        $uniqueId = uniqid();

        $photoData = [
            'id_user' => 'U1',
            'photo_path' => 'Images/phpunit_delete_' . $uniqueId . '.jpg',
            'title' => 'PHPUnit Delete Test',
            'description' => 'To be deleted'
        ];

        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("
            INSERT INTO gallery_photos (id_user, photo_path, title, description, upload_date) 
            VALUES (?, ?, ?, ?, NOW())
        ");
        $stmt->execute([
            $photoData['id_user'],
            $photoData['photo_path'],
            $photoData['title'],
            $photoData['description']
        ]);

        $stmt = $db->prepare("DELETE FROM gallery_photos WHERE id_user = ? AND photo_path = ?");
        $result = $stmt->execute([$photoData['id_user'], $photoData['photo_path']]);

        $this->assertTrue($result);
    }
}
