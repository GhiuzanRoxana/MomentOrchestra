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
                        Moment Orchestra este o platformă dedicată iubitorilor de muzică de petrecere și concerte
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
                    <p>Concerte, nunți, botezuri și multe altele.</p>
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
                        <a href="https://www.facebook.com/profile.php?id=61568308408269" target="_blank" title="Facebook">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                            </svg>
                        </a>
                        <a href="https://www.instagram.com/momentorchestra" target="_blank" title="Instagram">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                            </svg>
                        </a>
                        <a href="https://www.youtube.com/@momentorchestra16" target="_blank" title="YouTube">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                            </svg>
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