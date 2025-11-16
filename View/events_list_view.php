<!DOCTYPE html>
<html lang="ro">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evenimente - Moment Orchestra</title>
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
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
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
            background: linear-gradient(135deg, var(--highlight-color), var(--highlight-color));
            color: white;
            padding: 30px 25px;
        }

        .event-card-header h3 {
            margin: 0 0 10px 0;
            font-size: 22px;
        }

        .event-date {
            font-size: 14px;
            opacity: 0.9;
        }

        .event-card-body {
            padding: 25px;
        }

        .event-info {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: #666;
        }

        .event-description {
            color: #444;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .event-status {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
        }

        .status-active {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .no-events {
            text-align: center;
            padding: 100px 20px;
            color: #666;
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
            <h1>Evenimente Moment Orchestra</h1>
            <p>Descoperă concertele și evenimentele noastre viitoare</p>
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
                                <div class="event-date">
                                    📅 <?= date('d F Y, H:i', strtotime($event['event_date'])) ?>
                                </div>
                            </div>
                            <div class="event-card-body">
                                <div class="event-info">
                                    📍 <?= htmlspecialchars($event['location_name'] ?? 'Locație necunoscută') ?>
                                    <?php if (!empty($event['city'])): ?>
                                        , <?= htmlspecialchars($event['city']) ?>
                                    <?php endif; ?>
                                </div>

                                <?php if (!empty($event['description'])): ?>
                                    <p class="event-description">
                                        <?= htmlspecialchars(substr($event['description'], 0, 150)) ?>...
                                    </p>
                                <?php endif; ?>

                                <div style="margin-bottom: 15px;">
                                    <span class="event-status status-active">
                                        <?= htmlspecialchars($event['status_name'] ?? 'Activ') ?>
                                    </span>
                                </div>

                                <a href="event_detail.php?id=<?= $event['id_event'] ?>" class="btn btn-primary">
                                    Vezi Detalii
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="no-events">
                    <h2>Nu există evenimente disponibile momentan</h2>
                    <p>Revino curând pentru a descoperi evenimente noi!</p>
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