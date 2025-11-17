<!DOCTYPE html>
<html lang="ro">

<head>
    <meta charset="UTF-8">
    <title>Rezervare - Moment Orchestra</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .form-container {
            max-width: 700px;
            margin: 0 auto;
            background: white;
            padding: 50px;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 10px;
            font-weight: 700;
            color: #333;
            font-size: 15px;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 15px;
            border: 2px solid #ddd;
            border-radius: 10px;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #00d4ff;
        }

        .form-group small {
            display: block;
            margin-top: 8px;
            color: #666;
            font-size: 13px;
        }

        .info-box {
            background: #fff9e6;
            border: 1px solid #ffe066;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
        }

        .success-box {
            background: #e8f5e9;
            color: #2e7d32;
            padding: 30px;
            border-radius: 15px;
            text-align: center;
        }

        .error-box {
            background: #ffe6e6;
            color: #c62828;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
            text-align: center;
        }

        .btn-submit {
            width: 100%;
            background: #00d4ff;
            color: #000;
            padding: 18px;
            border: none;
            border-radius: 10px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-submit:hover {
            background: #00bfff;
            transform: translateY(-2px);
        }

        .date-header {
            background: #f0f9ff;
            border-left: 4px solid #00d4ff;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>

    <section style="padding:80px 0;background:#f4f4f4;">
        <div class="container">
            <div class="form-container">

                <?php if ($success): ?>
                    <div class="success-box">
                        <h2 style="margin:0 0 15px 0;">✓ Cerere de Rezervare Trimisă!</h2>
                        <p style="margin:0 0 10px 0;">Rezervarea ta este în așteptare.</p>
                        <p style="margin:0;">Adminul va verifica și confirma în curând.</p>
                    </div>
                    <div style="text-align:center;margin-top:30px;">
                        <a href="reservations.php" style="display:inline-block;background:#00d4ff;color:#000;padding:15px 40px;border-radius:30px;text-decoration:none;font-weight:bold;margin-right:15px;">
                            Vezi Rezervările Mele
                        </a>
                        <a href="events.php" style="display:inline-block;background:#666;color:white;padding:15px 40px;border-radius:30px;text-decoration:none;font-weight:bold;">
                            Înapoi la Date
                        </a>
                    </div>
                <?php else: ?>

                    <h1 style="text-align:center;margin-bottom:10px;">📩 Formular de Rezervare</h1>
                    <p style="text-align:center;color:#666;margin-bottom:40px;">Completează detaliile pentru a rezerva data</p>

                    <div class="date-header">
                        <h3 style="color:#00d4ff;margin:0 0 5px 0;font-size:24px;">📅 <?= htmlspecialchars($event['title']) ?></h3>
                        <p style="margin:0;color:#666;">Data selectată pentru evenimentul tău</p>
                    </div>

                    <?php if ($error): ?>
                        <div class="error-box">
                            ⚠️ <?= htmlspecialchars($error) ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" id="reservationForm">

                        <div class="form-group">
                            <label>Tip Eveniment *</label>
                            <select name="event_type" required>
                                <option value="">Selectează tipul evenimentului</option>
                                <option value="Nuntă">💍 Nuntă</option>
                                <option value="Botez">👶 Botez</option>
                                <option value="Aniversare">🎂 Aniversare</option>
                                <option value="Logodnă">💐 Logodnă</option>
                                <option value="Petrecere Privată">🎉 Petrecere Privată</option>
                                <option value="Eveniment Corporativ">🏢 Eveniment Corporativ</option>
                                <option value="Concert Privat">🎵 Concert Privat</option>
                                <option value="Altele">📝 Altele</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Locația Evenimentului *</label>
                            <input type="text" name="location" required
                                placeholder="ex: Restaurant Elite, Roman, Neamț">
                            <small>📍 Unde se va desfășura evenimentul</small>
                        </div>

                        <div class="form-group">
                            <label>Ora de Începere *</label>
                            <input type="time" name="event_time" required>
                            <small>🕐 La ce oră începe evenimentul</small>
                        </div>

                        <div class="form-group">
                            <label>Avans (RON) *</label>
                            <input type="number" name="price" required min="1000" step="100"
                                placeholder="Minim 1000 RON">
                            <small>💰 Avansul minim este de 1000 RON</small>
                        </div>

                        <div class="form-group">
                            <label>Număr Invitați (estimativ)</label>
                            <input type="number" name="guests" min="10" placeholder="ex: 100">
                        </div>

                        <div class="form-group">
                            <label>Detalii Suplimentare *</label>
                            <textarea name="details" rows="5" required
                                placeholder="Descrie evenimentul: stil muzical preferat, cerințe speciale, program aproximativ, etc."></textarea>
                        </div>

                        <div class="info-box">
                            <p style="margin:0;color:#666;font-size:14px;line-height:1.6;">
                                <strong>ℹ️ Notă Importantă:</strong><br>
                                • Rezervarea va fi <strong>în așteptare</strong> până la confirmarea adminului<br>
                                • Vei fi contactat în maximum 24h pentru confirmare<br>
                                • Avansul se achită după confirmarea adminului
                            </p>
                        </div>

                        <button type="submit" class="btn-submit">
                            📩 Trimite Cerere de Rezervare
                        </button>
                    </form>

                    <div style="text-align:center;margin-top:25px;">
                        <a href="events.php" style="color:#666;text-decoration:none;">← Înapoi la date disponibile</a>
                    </div>

                <?php endif; ?>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>

    <script>
        document.getElementById('reservationForm')?.addEventListener('submit', function(e) {
            const price = parseInt(document.querySelector('input[name="price"]').value);
            if (price < 1000) {
                e.preventDefault();
                alert('⚠️ Avansul minim este de 1000 RON!');
            }
        });
    </script>
</body>

</html>