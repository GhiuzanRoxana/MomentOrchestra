<?php

class GalleryController extends BaseController
{

    private $galleryModel;

    public function __construct()
    {
        parent::__construct();
        $this->galleryModel = new Gallery();
    }

    public function index()
    {
        return $this->galleryModel->readAll();
    }

    public function upload($file, $data)
    {
        $this->requireAdmin();

        $uploadDir = PUBLIC_PATH . '/Images/gallery/';
        $fileName = uniqid() . '_' . basename($file['name']);
        $uploadPath = $uploadDir . $fileName;

        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            $photoData = [
                'photo_path' => 'Images/gallery/' . $fileName,
                'title' => $this->sanitize($data['title']),
                'description' => $this->sanitize($data['description'] ?? ''),
                'uploaded_by_user_id' => $_SESSION['user_id']
            ];

            $photoId = $this->galleryModel->create($photoData);
            return ['success' => true, 'photo_id' => $photoId];
        }

        return ['success' => false, 'message' => 'Upload failed'];
    }

    public function delete($id)
    {
        $this->requireAdmin();
        return $this->galleryModel->delete($id);
    }
}
