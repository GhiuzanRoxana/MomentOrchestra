<!DOCTYPE html>
<html lang="ro">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Moment Orchestra</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <style>
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #000000ff, #000000ff);
            padding: 20px;
        }

        .login-box {
            background: white;
            border-radius: 15px;
            padding: 50px 40px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
            max-width: 450px;
            width: 100%;
        }

        .login-box h1 {
            text-align: center;
            color: #1a1a2e;
            margin-bottom: 10px;
            font-size: 32px;
        }

        .login-box .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 40px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
        }

        .form-group input {
            width: 100%;
            padding: 15px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--highlight-color);
        }

        .error-message {
            background: #ffe6e6;
            color: var(--highlight-color);
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
        }

        .btn-login {
            width: 100%;
            padding: 15px;
            background: var(--highlight-color);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-login:hover {
            background: var(--highlight-color);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(233, 69, 96, 0.3);
        }

        .register-link {
            text-align: center;
            margin-top: 25px;
            color: #666;
        }

        .back-home {
            text-align: center;
            margin-top: 15px;
        }

        .back-home a {
            color: #666;
            text-decoration: none;
        }

        .back-home a:hover {
            color: var(--highlight-color);
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-box">
            <h1>🎼 Moment Orchestra</h1>
            <p class="subtitle">Conectează-te la contul tău</p>

            <?php if (isset($error)): ?>
                <div class="error-message">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required autofocus>
                </div>

                <div class="form-group">
                    <label for="password">Parolă</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <button type="submit" class="btn-login">Login</button>
            </form>

            <div class="back-home">
                <a href="index.php">← Înapoi la pagina principală</a>
            </div>
        </div>
    </div>
</body>

</html>