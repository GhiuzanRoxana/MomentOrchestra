<!DOCTYPE html>
<html lang="ro">

<head>
    <meta charset="UTF-8">
    <title>Rezervările Mele - Moment Orchestra</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .page-header {
            background: linear-gradient(135deg, #000000, #1a1a1a);
            color: white;
            padding: 80px 0 60px;
            text-align: center;
        }

        .reservation-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .reservation-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 2px solid #f0f0f0;
        }

        .badge {
            padding: 8px 20px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
        }

        .badge-pending {
            background: #fff3cd;
            color: #856404;
        }

        .badge-confirmed {
            background: #d4edda;
            color: #155724;
        }

        .empty-state {
            text-align: center;
            padding: 100px 20px;
            background: white;
            border-radius: 15px;
            margin: 40px 0;
        }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>

    <section class="page-header">
        <div class="container">
            <h1>Rezervările Mele</h1>
            <p>Vezi statusul rezervărilor tale</p>
        </div>
    </section>

    <section style="padding:80px 0;background:#f4f4f4;min-height:70vh;">
        <div class="container" style="max-width:900px;">

            <?php if (!empty($reservations)): ?>
                <?php foreach ($reservations as $res): ?>
                    <div class="reservation-card">
                        <div class="reservation-header">
                            <div>
                                <h3 style="color:#00d4ff;margin:0 0 10px 0;font-size:22px;">
                                    📅 <?= htmlspecialchars($res['title']) ?>
                                </h3>
                                <p style="margin:0;color:#666;">
                                    🗓️ Data eveniment: <?= date('d F Y', strtotime($res['event_date'])) ?><br>
                                    💰 Avans: <?= number_format($res['price'], 0, ',', '.') ?> RON<br>
                                    📝 Tip: <?= htmlspecialchars($res['event_type'] ?? 'N/A') ?>
                                </p>
                            </div>
                            <span class="badge <?= $res['status'] === 'Confirmata' ? 'badge-confirmed' : 'badge-pending' ?>">
                                <?= $res['status'] === 'Confirmata' ? '✓ Confirmată' : '⏳ În Așteptare' ?>
                            </span>
                        </div>

                        <?php if ($res['status'] === 'In asteptare'): ?>
                            <div style="background:#fff9e6;padding:15px;border-radius:8px;border-left:4px solid #ffc107;">
                                <p style="margin:0;color:#856404;font-size:14px;">
                                    ⏳ Rezervarea ta este în așteptare. Adminul va confirma în curând!
                                </p>
                            </div>
                        <?php else: ?>
                            <div style="background:#e8f5e9;padding:15px;border-radius:8px;border-left:4px solid #28a745;">
                                <p style="margin:0;color:#155724;font-size:14px;">
                                    ✓ Rezervarea ta a fost confirmată! Vei fi contactat pentru detalii finale.
                                </p>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="empty-state">
                    <h2 style="color:#666;margin-bottom:20px;">📅 Nu ai nicio rezervare</h2>
                    <p style="color:#999;margin-bottom:30px;">Explorează evenimentele noastre și fă prima rezervare!</p>
                    <a href="events.php" style="display:inline-block;background:#00d4ff;color:#000;padding:15px 40px;border-radius:30px;text-decoration:none;font-weight:bold;">
                        Vezi Evenimente
                    </a>
                </div>
            <?php endif; ?>

        </div>
    </section>

    <?php include 'footer.php'; ?>
</body>

</html>