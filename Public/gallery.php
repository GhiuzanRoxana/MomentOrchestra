<?php
require_once '../config.php';

try {
    $galleryController = new GalleryController();
    $photos = $galleryController->index();
} catch (Exception $e) {
    $photos = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isAdmin() && isset($_FILES['photo'])) {
    $result = $galleryController->upload($_FILES['photo'], $_POST);

    if ($result['success']) {
        header('Location: gallery.php?uploaded=1');
        exit;
    }
}

include '../View/gallery_view.php';
