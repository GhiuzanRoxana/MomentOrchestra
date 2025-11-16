<!DOCTYPE html>
<html lang="ro">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moment Orchestra - Acasă</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
</head>

<body>

    <header class="main-header">
        <div class="container">
            <nav class="navbar">
                <div class="logo">
                    <h2>🎼 Moment Orchestra</h2>
                </div>
                <ul class="nav-menu">
                    <li><a href="index.php" class="active">Acasă</a></li>
                    <li><a href="events.php">Evenimente</a></li>
                    <li><a href="gallery.php">Galerie</a></li>
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

    <section class="hero-section">
        <div class="hero-overlay">
            <div class="container">
                <h1 class="hero-title">Moment Orchestra</h1>
                <div class="hero-buttons">
                    <a href="events.php" class="btn btn-primary">Vezi Evenimente</a>
                </div>
            </div>
        </div>
    </section>

    <section class="about-section">
        <div class="container">
            <h2 class="section-title">Despre Noi</h2>
            <div class="about-content">
                <div class="about-text">
                    <p>
                        Moment Orchestra este o platformă dedicată iubitorilor de muzică de petrcere si concerte
                    </p>
                    <p>
                        Cu o echipă de muzicieni profesioniști și organizatori dedicați,
                        creăm momente memorabile pentru fiecare eveniment.
                    </p>
                    <a href="https://www.wikipedia.org/wiki/Orchestra" target="_blank" class="link-external">
                        Citește mai mult despre orchestre →
                    </a>
                </div>
                <div class="about-image">
                    <img src="Images/eveniment1.jpg" alt="Orchestra Moment">
                </div>
            </div>
        </div>
    </section>

    <section class="audio-section">
        <div class="container">
            <h2 class="section-title">Ascultă un fragment</h2>
            <div class="audio-player">
                <audio controls>
                    <source src="audio/melodie.mpeg" type="audio/mpeg">
                    Browserul tău nu suportă redarea audio.
                </audio>
                <p class="audio-description">Melodia noastră</p>
            </div>
        </div>
    </section>

    <section class="features-section">
        <div class="container">
            <h2 class="section-title">De ce Moment Orchestra?</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">🎵</div>
                    <h3>Muzicieni Profesioniști</h3>
                    <p>Echipa noastră este formată din muzicieni cu experiență vastă.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">📅</div>
                    <h3>Rezervări Simple</h3>
                    <p>Sistem ușor de rezervare online pentru toate evenimentele.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🎭</div>
                    <h3>Evenimente Diverse</h3>
                </div>
            </div>
        </div>
    </section>

    <footer class="main-footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Moment Orchestra</h3>
                    <p>Creăm experiențe muzicale memorabile din 2024</p>
                </div>
                <div class="footer-section">
                    <h3>Link-uri Utile</h3>
                    <ul>
                        <li><a href="events.php">Evenimente</a></li>
                        <li><a href="gallery.php">Galerie</a></li>
                        <li><a href="reservations.php">Rezervări</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Contact</h3>
                    <p>📧 orchestramoment@gmail.com</p>
                    <p>📱 +40 (749) 315 987</p>
                    <p>📍 Roman, România</p>
                </div>
                <div class="footer-section">
                    <h3>Social Media</h3>
                    <div class="social-links">
                        <a href="#" title="Facebook">FB: https://www.facebook.com/profile.php?id=61568308408269</a>
                        <a href="#" title="Instagram">IG: momentorchestra</a>
                        <a href="#" title="YouTube">YT: @momentorchestra16
                        </a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 Moment Orchestra. Toate drepturile rezervate.</p>
            </div>
        </div>
    </footer>

    <script>
        const hamburger = document.querySelector('.hamburger');
        const navMenu = document.querySelector('.nav-menu');

        hamburger.addEventListener('click', () => {
            hamburger.classList.toggle('active');
            navMenu.classList.toggle('active');
        });

        document.querySelectorAll('.nav-menu a').forEach(link => {
            link.addEventListener('click', () => {
                hamburger.classList.remove('active');
                navMenu.classList.remove('active');
            });
        });
    </script>
</body>

</html>