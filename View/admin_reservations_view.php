<!DOCTYPE html>
<html lang="ro">

<head>
    <meta charset="UTF-8">
    <title>Admin - Rezervări</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .admin-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .section-title {
            font-size: 28px;
            margin-bottom: 30px;
            color: #333;
            border-bottom: 3px solid #00d4ff;
            padding-bottom: 10px;
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

        .reservation-title {
            font-size: 22px;
            color: #00d4ff;
            margin: 0 0 10px 0;
        }

        .reservation-meta {
            color: #666;
            font-size: 14px;
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

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .info-item {
            padding: 15px;
            background: #f9f9f9;
            border-radius: 8px;
        }

        .info-label {
            font-size: 12px;
            color: #666;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .info-value {
            font-size: 16px;
            color: #333;
            font-weight: 600;
        }

        .details-box {
            background: #f0f9ff;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            white-space: pre-wrap;
            line-height: 1.8;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .btn-confirm {
            flex: 1;
            background: #28a745;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-confirm:hover {
            background: #218838;
            transform: translateY(-2px);
        }

        .btn-cancel {
            flex: 1;
            background: #dc3545;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-cancel:hover {
            background: #c82333;
            transform: translateY(-2px);
        }

        .success-alert {
            background: #d4edda;
            color: #155724;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 25px;
            text-align: center;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>

    <section style="padding:80px 0;background:#f4f4f4;min-height:100vh;">
        <div class="admin-container">

            <h1 style="text-align:center;margin-bottom:50px;font-size:36px;">
                👨‍💼 Panou Admin - Rezervări
            </h1>

            <?php if (isset($success)): ?>
                <div class="success-alert">
                    ✓ <?= htmlspecialchars($success) ?>
                </div>
            <?php endif; ?>

            <h2 class="section-title">⏳ Cereri în Așteptare (<?= count($pendingReservations) ?>)</h2>

            <?php if (!empty($pendingReservations)): ?>
                <?php foreach ($pendingReservations as $res): ?>
                    <div class="reservation-card">
                        <div class="reservation-header">
                            <div>
                                <h3 class="reservation-title">
                                    📅 <?= htmlspecialchars($res['event_title']) ?>
                                </h3>
                                <div class="reservation-meta">
                                    👤 <strong><?= htmlspecialchars($res['full_name']) ?></strong> (<?= htmlspecialchars($res['username']) ?>)<br>
                                    📧 <?= htmlspecialchars($res['email']) ?><br>
                                    🕐 Cerere trimisă: <?= date('d.m.Y H:i', strtotime($res['reservation_date'])) ?>
                                </div>
                            </div>
                            <span class="badge badge-pending">⏳ În Așteptare</span>
                        </div>

                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-label">Tip Eveniment</div>
                                <div class="info-value"><?= htmlspecialchars($res['event_type']) ?></div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Data Eveniment</div>
                                <div class="info-value"><?= date('d F Y', strtotime($res['event_date'])) ?></div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Avans</div>
                                <div class="info-value"><?= number_format($res['price'], 0, ',', '.') ?> RON</div>
                            </div>
                        </div>

                        <div class="details-box">
                            <strong>📝 Detalii Complete:</strong><br>
                            <?= htmlspecialchars($res['details']) ?>
                        </div>

                        <form method="POST" style="display:inline;" onsubmit="return confirm('Confirmi această rezervare?');">
                            <input type="hidden" name="id_user" value="<?= $res['id_user'] ?>">
                            <input type="hidden" name="id_event" value="<?= $res['id_event'] ?>">
                            <input type="hidden" name="action" value="confirm">

                            <div class="action-buttons">
                                <button type="submit" class="btn-confirm">
                                    ✓ Confirmă Rezervarea
                                </button>
                                <button type="submit" class="btn-cancel"
                                    formaction=""
                                    onclick="this.form.action.value='cancel'; return confirm('Anulezi rezervarea? Data va deveni disponibilă din nou.');">
                                    ✗ Anulează Cererea
                                </button>
                            </div>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="empty-state">
                    <h3>✓ Nu există cereri în așteptare</h3>
                    <p>Toate rezervările au fost procesate</p>
                </div>
            <?php endif; ?>

            <h2 class="section-title" style="margin-top:60px;">✓ Rezervări Confirmate (<?= count($confirmedReservations) ?>)</h2>

            <?php if (!empty($confirmedReservations)): ?>
                <?php foreach ($confirmedReservations as $res): ?>
                    <div class="reservation-card">
                        <div class="reservation-header">
                            <div>
                                <h3 class="reservation-title">
                                    📅 <?= htmlspecialchars($res['event_title']) ?>
                                </h3>
                                <div class="reservation-meta">
                                    👤 <strong><?= htmlspecialchars($res['full_name']) ?></strong><br>
                                    📧 <?= htmlspecialchars($res['email']) ?>
                                </div>
                            </div>
                            <span class="badge badge-confirmed">✓ Confirmată</span>
                        </div>

                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-label">Tip</div>
                                <div class="info-value"><?= htmlspecialchars($res['event_type']) ?></div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Data</div>
                                <div class="info-value"><?= date('d F Y', strtotime($res['event_date'])) ?></div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Avans</div>
                                <div class="info-value"><?= number_format($res['price'], 0, ',', '.') ?> RON</div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="empty-state">
                    <h3>Încă nu există rezervări confirmate</h3>
                </div>
            <?php endif; ?>

        </div>
    </section>

    <?php include 'footer.php'; ?>
</body>

</html>