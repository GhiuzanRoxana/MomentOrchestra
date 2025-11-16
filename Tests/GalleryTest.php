<?php

use PHPUnit\Framework\TestCase;

if (!defined('DB_HOST')) {
    require_once __DIR__ . '/../config.php';
}

class GalleryTest extends TestCase
{

    private $galleryModel;

    protected function setUp(): void
    {
        $this->galleryModel = new Gallery();
    }

    public function testCreateGalleryPhoto()
    {
        $photoData = [
            'photo_path' => 'Images/gallery/test_photo_' . time() . '.jpg',
            'title' => 'Test Photo ' . time(),
            'description' => 'Test photo description',
            'uploaded_by_user_id' => 'U1'
        ];

        $photoId = $this->galleryModel->create($photoData);

        $this->assertNotEmpty($photoId);
        $this->assertStringContainsString('U1_', $photoId);
    }

    public function testReadGalleryPhoto()
    {
        $photoData = [
            'photo_path' => 'Images/gallery/read_test_' . time() . '.jpg',
            'title' => 'Read Test Photo',
            'description' => 'Photo for reading test',
            'uploaded_by_user_id' => 'U1'
        ];

        $photoId = $this->galleryModel->create($photoData);
        $photo = $this->galleryModel->read($photoId);

        $this->assertNotEmpty($photo);
        $this->assertEquals($photoData['title'], $photo['title']);
    }

    public function testReadAllGalleryPhotos()
    {
        $photos = $this->galleryModel->readAll();

        $this->assertIsArray($photos);
    }

    public function testUpdateGalleryPhoto()
    {
        $photoData = [
            'photo_path' => 'Images/gallery/update_test_' . time() . '.jpg',
            'title' => 'Original Title',
            'description' => 'Original description',
            'uploaded_by_user_id' => 'U1'
        ];

        $photoId = $this->galleryModel->create($photoData);

        $updateData = [
            'title' => 'Updated Photo Title',
            'description' => 'Updated description'
        ];

        $result = $this->galleryModel->update($photoId, $updateData);

        $this->assertTrue($result);

        $updatedPhoto = $this->galleryModel->read($photoId);
        $this->assertEquals($updateData['title'], $updatedPhoto['title']);
    }

    public function testDeleteGalleryPhoto()
    {
        $photoData = [
            'photo_path' => 'Images/gallery/delete_test_' . time() . '.jpg',
            'title' => 'Delete Test Photo',
            'description' => 'Photo to be deleted',
            'uploaded_by_user_id' => 'U1'
        ];

        $photoId = $this->galleryModel->create($photoData);
        $result = $this->galleryModel->delete($photoId);

        $this->assertTrue($result);

        $deletedPhoto = $this->galleryModel->read($photoId);
        $this->assertFalse($deletedPhoto);
    }
}
