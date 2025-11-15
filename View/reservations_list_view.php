<!DOCTYPE html>
<html lang="ro">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rezervările Mele - Moment Orchestra</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <style>
        .reservations-container {
            min-height: 70vh;
            padding: 80px 0;
        }

        .reservation-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 30px;
            align-items: center;
        }

        .reservation-info h3 {
            color: #1a1a2e;
            margin-bottom: 15px;
        }

        .reservation-details {
            display: flex;
            gap: 30px;
            flex-wrap: wrap;
            color: #666;
        }

        .detail-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .reservation-actions {
            display: flex;
            gap: 15px;
            flex-direction: column;
        }

        .btn-cancel {
            padding: 10px 25px;
            background: #f44336;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-cancel:hover {
            background: #d32f2f;
        }

        .no-reservations {
            text-align: center;
            padding: 80px 20px;
        }

        .no-reservations h2 {
            color: #666;
            margin-bottom: 20px;
        }

        .success-alert {
            background: #e8f5e9;
            color: #2e7d32;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }

        @media (max-width: 768px) {
            .reservation-card {
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
                    <li><a href="events.php">Evenimente</a></li>
                    <li><a href="gallery.php">Galerie</a></li>
                    <li><a href="reservations.php" class="active">Rezervări</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
                <div class="hamburger">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </nav>
        </div>
    </header>

    <section class="reservations-container">
        <div class="container">
            <h1 style="margin-bottom: 40px;">Rezervările Mele</h1>

            <?php if (isset($_GET['cancelled'])): ?>
                <div class="success-alert">
                    ✓ Rezervare anulată cu succes!
                </div>
            <?php endif; ?>

            <?php if (!empty($reservations)): ?>
                <?php foreach ($reservations as $reservation): ?>
                    <div class="reservation-card">
                        <div class="reservation-info">
                            <h3><?= htmlspecialchars($reservation['title']) ?></h3>
                            <div class="reservation-details">
                                <div class="detail-item">
                                    📅 <?= date('d F Y, H:i', strtotime($reservation['event_date'])) ?>
                                </div>
                                <div class="detail-item">
                                    💰 <?= number_format($reservation['price'], 2) ?> RON
                                </div>
                                <div class="detail-item">
                                    ✅ Status: <?= htmlspecialchars($reservation['status']) ?>
                                </div>
                                <div class="detail-item">
                                    🎫 Rezervat: <?= date('d.m.Y', strtotime($reservation['reservation_date'])) ?>
                                </div>
                            </div>
                        </div>

                        <div class="reservation-actions">
                            <a href="event_detail.php?id=<?= $reservation['id_event'] ?>"
                                class="btn btn-primary">
                                Vezi Detalii
                            </a>
                            <form method="POST" onsubmit="return confirm('Sigur vrei să anulezi rezervarea?');">
                                <input type="hidden" name="cancel_id" value="<?= $reservation['id_user'] ?>_<?= $reservation['id_event'] ?>">
                                <button type="submit" name="cancel" class="btn-cancel">
                                    Anulează
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="no-reservations">
                    <h2>Nu ai nicio rezervare</h2>
                    <p>Explorează evenimentele noastre și fă prima rezervare!</p>
                    <br>
                    <a href="events.php" class="btn btn-primary">Vezi Evenimente</a>
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