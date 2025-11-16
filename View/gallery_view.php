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
                        <li><a href="logout.php">Logout (<?= htmlspecialchars($_SESSION['username']) ?>)</a></li>
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
            <h2 class="section-title">Galerie Evenimente</h2>

            <?php
            $eventPhotos = array_filter($photos, function ($photo) {
                return strpos(strtolower($photo['photo_path']), 'eveniment') !== false;
            });
            $eventPhotos = array_slice($eventPhotos, 0, 10);
            ?>

            <div id="gallery-carousel">
                <?php foreach ($eventPhotos as $photo): ?>
                    <div
                        data-carousel-image="<?= htmlspecialchars($photo['photo_path']) ?>"
                        data-caption="<?= htmlspecialchars($photo['title']) ?>">
                    </div>
                <?php endforeach; ?>
            </div>

        </div>
    </section>

    <section class="gallery-grid-section">
        <div class="container">
            <h2 class="section-title">👥 Membri Formației</h2>

            <?php
            $memberPhotos = array_filter($photos, function ($photo) {
                $file = strtolower($photo['photo_path']);
                return strpos($file, 'eveniment') === false && strpos($file, 'first') === false;
            });
            ?>

            <?php if (!empty($memberPhotos)): ?>
                <div class="gallery-grid">
                    <?php foreach ($memberPhotos as $photo): ?>
                        <div class="gallery-item">
                            <img src="<?= htmlspecialchars($photo['photo_path']) ?>"
                                alt="<?= htmlspecialchars($photo['title']) ?>">
                            <div class="gallery-overlay">
                                <h3><?= htmlspecialchars($photo['title']) ?></h3>
                                <?php if (!empty($photo['description'])): ?>
                                    <p><?= htmlspecialchars($photo['description']) ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div style="text-align:center;padding:60px 20px;color:#666;">
                    <h3>Nu există fotografii cu membrii</h3>
                    <p>Revino curând pentru a vedea fotografii noi!</p>
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
        document.addEventListener('DOMContentLoaded', function() {
            const hamburger = document.querySelector('.hamburger');
            const navMenu = document.querySelector('.nav-menu');
            if (hamburger && navMenu) {
                hamburger.addEventListener('click', () => {
                    hamburger.classList.toggle('active');
                    navMenu.classList.toggle('active');
                });
            }
        });
    </script>

</body>

</html>