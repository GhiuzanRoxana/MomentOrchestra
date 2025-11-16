<?php
require_once '../config.php';

$galleryModel = new Gallery();
$photos = $galleryModel->readAll();

$userModel = new User();
$memberPhotos = [];

foreach ($photos as $photo) {
    if (stripos($photo['id_user'], 'U') === 0 && strlen($photo['id_user']) <= 3) {
        $memberPhotos[] = $photo;
    }
}

include '../View/gallery_view.php';
