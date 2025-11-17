<!DOCTYPE html>
<html lang="ro">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Date Disponibile - Moment Orchestra</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <style>
        .page-header {
            background: linear-gradient(135deg, #000000ff, #000000ff);
            color: white;
            padding: 80px 0 60px;
            text-align: center;
        }

        .events-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 30px;
            padding: 60px 0;
        }

        .event-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
        }

        .event-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .event-card-header {
            background: linear-gradient(135deg, #00d4ff, #00bfff);
            color: #000;
            padding: 40px 25px;
            text-align: center;
        }

        .event-card-header h3 {
            margin: 0;
            font-size: 26px;
            font-weight: bold;
        }

        .event-card-body {
            padding: 30px 25px;
            text-align: center;
        }

        .event-status {
            display: inline-block;
            padding: 10px 25px;
            border-radius: 20px;
            font-size: 15px;
            font-weight: 600;
            background: #e8f5e9;
            color: #2e7d32;
            margin-bottom: 25px;
        }

        .btn-reserve {
            display: inline-block;
            width: 100%;
            background: #00d4ff;
            color: #000;
            padding: 15px 30px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: bold;
            text-align: center;
            transition: all 0.3s;
            border: 2px solid #00d4ff;
            font-size: 16px;
        }

        .btn-reserve:hover {
            background: transparent;
            color: #00d4ff;
            transform: scale(1.05);
        }

        .btn-login {
            display: inline-block;
            width: 100%;
            background: #666;
            color: white;
            padding: 15px 30px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: bold;
            text-align: center;
            transition: all 0.3s;
            font-size: 16px;
        }

        .btn-login:hover {
            background: #555;
        }

        .no-events {
            text-align: center;
            padding: 100px 20px;
            color: #666;
            background: #f9f9f9;
            border-radius: 15px;
            margin: 60px 0;
        }
    </style>
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
                    <li><a href="events.php" class="active">Evenimente</a></li>
                    <li><a href="gallery.php">Galerie</a></li>
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
            <h1>📅 Date Disponibile</h1>
            <p>Rezervă Orchestra Moment pentru evenimentul tău</p>
        </div>
    </section>

    <section>
        <div class="container">
            <?php if (!empty($events)): ?>
                <div class="events-grid">
                    <?php foreach ($events as $event): ?>
                        <div class="event-card">
                            <div class="event-card-header">
                                <h3><?= htmlspecialchars($event['title']) ?></h3>
                            </div>
                            <div class="event-card-body">
                                <span class="event-status">
                                    ✓ Disponibil
                                </span>

                                <?php if (isLoggedIn() && !isAdmin()): ?>
                                    <a href="event_detail.php?id=<?= $event['id_event'] ?>" class="btn-reserve">
                                        📩 Rezervă Data
                                    </a>
                                <?php elseif (isAdmin()): ?>
                                    <div style="padding:15px;background:#f0f0f0;border-radius:10px;text-align:center;color:#666;">
                                        ℹ️ Admin - Nu poți face rezervări
                                    </div>
                                <?php else: ?>
                                    <a href="login.php" class="btn-login">
                                        🔒 Login pentru Rezervare
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="no-events">
                    <h2>📅 Nu există date disponibile momentan</h2>
                    <p>Toate datele sunt rezervate. Contactează-ne pentru mai multe informații!</p>
                    <p style="margin-top:20px;">
                        <strong>📧 contact@momentorchestra.ro</strong> |
                        <strong>📱 +40 123 456 789</strong>
                    </p>
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