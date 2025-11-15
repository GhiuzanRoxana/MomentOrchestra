<!DOCTYPE html>
<html lang="ro">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Moment Orchestra' ?></title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <?php if (isset($extraCSS)): ?>
        <?php foreach ($extraCSS as $css): ?>
            <link rel="stylesheet" href="<?= $css ?>">
        <?php endforeach; ?>
    <?php endif; ?>
</head>

<body>
    <header class="main-header">
        <div class="container">
            <nav class="navbar">
                <div class="logo">
                    <h2>🎼 Moment Orchestra</h2>
                </div>
                <ul class="nav-menu">
                    <li><a href="index.php" <?= ($currentPage ?? '') === 'home' ? 'class="active"' : '' ?>>Acasă</a></li>
                    <li><a href="events.php" <?= ($currentPage ?? '') === 'events' ? 'class="active"' : '' ?>>Evenimente</a></li>
                    <li><a href="gallery.php" <?= ($currentPage ?? '') === 'gallery' ? 'class="active"' : '' ?>>Galerie</a></li>
                    <li><a href="reservations.php" <?= ($currentPage ?? '') === 'reservations' ? 'class="active"' : '' ?>>Rezervări</a></li>
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