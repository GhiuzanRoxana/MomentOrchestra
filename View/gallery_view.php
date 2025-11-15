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
?>
<!DOCTYPE html>
<html lang="ro">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galerie - Moment Orchestra</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/carousel.css">
    <link rel="stylesheet" href="css/gallery.css">
</head>

<body>

    <header class="main-header">
        <div class="container">
            <nav class="navbar">
                <div class="logo">
                    <h2>🎼 Moment Orchestra</h2>
                </div>
                <ul class="nav-menu">
                    <li><a href="index.php">Acasă</a></li>
                    <li><a href="events.php">Evenimente</a></li>
                    <li><a href="gallery.php" class="active">Galerie</a></li>
                    <li><a href="reservations.php">Rezervări</a></li>
                    <?php if (isLoggedIn()): ?>
                        <li><a href="logout.php">Logout</a></li>
                    <?php else: ?>
                        <li><a href="login.php">Login</a></li>
                    <?php endif; ?>
                </ul>
                <div class="hamburger">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </nav>
        </div>
    </header>

    <section class="page-header">
        <div class="container">
            <h1>Galerie Foto</h1>
            <p>Momente memorabile din concertele noastre</p>
        </div>
    </section>

    <section class="gallery-carousel-section">
        <div class="container">
            <h2 class="section-title">Imagini Destacate</h2>

            <div id="gallery-carousel">
                <?php if (!empty($photos)): ?>
                    <?php foreach (array_slice($photos, 0, 5) as $photo): ?>
                        <img src="<?= htmlspecialchars($photo['photo_path']) ?>"
                            alt="<?= htmlspecialchars($photo['title']) ?>"
                            data-caption="<?= htmlspecialchars($photo['title']) ?>">
                    <?php endforeach; ?>
                <?php else: ?>
                    <img src="Images/First.jpg" alt="Moment Orchestra" data-caption="Moment Orchestra">
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section class="gallery-grid-section">
        <div class="container">
            <h2 class="section-title">Toate Fotografiile</h2>

            <?php if (isset($_GET['uploaded'])): ?>
                <div style="background:#e8f5e9;color:#2e7d32;padding:15px;border-radius:8px;margin-bottom:30px;text-align:center;">
                    ✓ Fotografie încărcată cu succes!
                </div>
            <?php endif; ?>

            <?php if (!empty($photos)): ?>
                <div class="gallery-grid">
                    <?php foreach ($photos as $photo): ?>
                        <div class="gallery-item">
                            <img src="<?= htmlspecialchars($photo['photo_path']) ?>"
                                alt="<?= htmlspecialchars($photo['title']) ?>">
                            <div class="gallery-overlay">
                                <h3><?= htmlspecialchars($photo['title']) ?></h3>
                                <p><?= date('d.m.Y', strtotime($photo['upload_date'])) ?></p>
                                <?php if (!empty($photo['description'])): ?>
                                    <p><?= htmlspecialchars($photo['description']) ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div style="text-align:center;padding:60px 20px;color:#666;">
                    <h3>Nu există fotografii în galerie</h3>
                    <p>Revino curând pentru a vedea fotografii noi!</p>
                </div>
            <?php endif; ?>

            <?php if (isAdmin()): ?>
                <div class="upload-section" style="display:block;margin-top:60px;">
                    <h3>Upload Foto Nouă (Admin)</h3>
                    <form method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Selectează imagine:</label>
                            <input type="file" name="photo" accept="image/*" required>
                        </div>
                        <div class="form-group">
                            <label>Titlu:</label>
                            <input type="text" name="title" required>
                        </div>
                        <div class="form-group">
                            <label>Descriere:</label>
                            <textarea name="description" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <footer class="main-footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Moment Orchestra</h3>
                    <p>Creăm experiențe muzicale memorabile.</p>
                </div>
                <div class="footer-section">
                    <h3>Link-uri</h3>
                    <ul>
                        <li><a href="index.php">Acasă</a></li>
                        <li><a href="events.php">Evenimente</a></li>
                        <li><a href="gallery.php">Galerie</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Contact</h3>
                    <p>📧 contact@momentorchestra.ro</p>
                    <p>📱 +40 123 456 789</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 Moment Orchestra</p>
            </div>
        </div>
    </footer>

    <script src="js/carousel.js"></script>
    <script>
        const hamburger = document.querySelector('.hamburger');
        const navMenu = document.querySelector('.nav-menu');

        hamburger.addEventListener('click', () => {
            hamburger.classList.toggle('active');
            navMenu.classList.toggle('active');
        });
    </script>
</body>

</html>