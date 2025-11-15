<?php
require_once '../config.php';

$eventId = $_GET['id'] ?? null;

if (!$eventId) {
    header('Location: events.php');
    exit;
}

try {
    $eventController = new EventController();
    $event = $eventController->show($eventId);

    if (!$event) {
        header('Location: events.php');
        exit;
    }
} catch (Exception $e) {
    header('Location: events.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isLoggedIn()) {
    $reservationController = new ReservationController();
    $result = $reservationController->create([
        'id_event' => $eventId,
        'price' => $_POST['price'] ?? 0
    ]);

    if ($result['success']) {
        $success = "Rezervare realizată cu succes!";
    } else {
        $error = "Eroare la rezervare.";
    }
}
?>
<!DOCTYPE html>
<html lang="ro">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($event['title']) ?> - Moment Orchestra</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <style>
        .event-detail-header {
            background: linear-gradient(135deg, #1a1a2e, #16213e);
            color: white;
            padding: 100px 0 60px;
        }

        .event-detail-header h1 {
            font-size: 42px;
            margin-bottom: 20px;
        }

        .event-meta {
            display: flex;
            gap: 30px;
            flex-wrap: wrap;
            font-size: 18px;
            opacity: 0.9;
        }

        .event-meta-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .event-detail-content {
            padding: 60px 0;
        }

        .event-info-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 40px;
            margin-bottom: 40px;
        }

        .event-description {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .event-description h2 {
            color: #1a1a2e;
            margin-bottom: 20px;
        }

        .event-description p {
            line-height: 1.8;
            color: #444;
            font-size: 16px;
        }

        .event-sidebar {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            height: fit-content;
        }

        .sidebar-section {
            margin-bottom: 25px;
            padding-bottom: 25px;
            border-bottom: 1px solid #eee;
        }

        .sidebar-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }

        .sidebar-section h3 {
            color: #1a1a2e;
            margin-bottom: 15px;
            font-size: 18px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .reserve-form input {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .btn-reserve {
            width: 100%;
            padding: 15px;
            background: #e94560;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-reserve:hover {
            background: #d63850;
            transform: translateY(-2px);
        }

        .success-message {
            background: #e8f5e9;
            color: #2e7d32;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .error-message {
            background: #ffebee;
            color: #c62828;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .event-info-grid {
                grid-template-columns: 1fr;
            }
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

    <section class="event-detail-header">
        <div class="container">
            <h1><?= htmlspecialchars($event['title']) ?></h1>
            <div class="event-meta">
                <div class="event-meta-item">
                    📅 <?= date('d F Y, H:i', strtotime($event['event_date'])) ?>
                </div>
                <div class="event-meta-item">
                    📍 <?= htmlspecialchars($event['location_name'] ?? 'Locație necunoscută') ?>
                </div>
                <div class="event-meta-item">
                    ✨ <?= htmlspecialchars($event['status_name'] ?? 'Activ') ?>
                </div>
            </div>
        </div>
    </section>

    <section class="event-detail-content">
        <div class="container">
            <?php if (isset($success)): ?>
                <div class="success-message"><?= $success ?></div>
            <?php endif; ?>

            <?php if (isset($error)): ?>
                <div class="error-message"><?= $error ?></div>
            <?php endif; ?>

            <div class="event-info-grid">
                <div class="event-description">
                    <h2>Despre eveniment</h2>
                    <p><?= nl2br(htmlspecialchars($event['description'] ?? 'Fără descriere disponibilă.')) ?></p>
                </div>

                <div class="event-sidebar">
                    <div class="sidebar-section">
                        <h3>Detalii</h3>
                        <div class="info-row">
                            <strong>Data:</strong>
                            <span><?= date('d.m.Y', strtotime($event['event_date'])) ?></span>
                        </div>
                        <div class="info-row">
                            <strong>Ora:</strong>
                            <span><?= date('H:i', strtotime($event['event_date'])) ?></span>
                        </div>
                        <div class="info-row">
                            <strong>Locație:</strong>
                            <span><?= htmlspecialchars($event['location_name'] ?? 'N/A') ?></span>
                        </div>
                        <?php if (!empty($event['city'])): ?>
                            <div class="info-row">
                                <strong>Oraș:</strong>
                                <span><?= htmlspecialchars($event['city']) ?></span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if (isLoggedIn()): ?>
                        <div class="sidebar-section">
                            <h3>Rezervă acum</h3>
                            <form method="POST" class="reserve-form">
                                <input type="number" name="price" placeholder="Preț (opțional)" min="0" step="0.01">
                                <button type="submit" class="btn-reserve">Rezervă Bilet</button>
                            </form>
                        </div>
                    <?php else: ?>
                        <div class="sidebar-section">
                            <h3>Rezervă acum</h3>
                            <p style="margin-bottom:15px;">Pentru a face o rezervare, trebuie să fii autentificat.</p>
                            <a href="login.php" class="btn btn-primary" style="display:block;text-align:center;">Login</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div style="text-align:center;">
                <a href="events.php" class="btn btn-secondary">← Înapoi la evenimente</a>
            </div>
        </div>
    </section>

    <footer class="main-footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Moment Orchestra</h3>
                    <p>Creăm experiențe muzicale memorabile.</p>
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