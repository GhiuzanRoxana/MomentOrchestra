<!DOCTYPE html>
<html lang="ro">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Înregistrare - Moment Orchestra</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <style>
        .register-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #16213e, #0f3460);
            padding: 40px 20px;
        }

        .register-box {
            background: white;
            border-radius: 15px;
            padding: 50px 40px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
            max-width: 500px;
            width: 100%;
        }

        .register-box h1 {
            text-align: center;
            color: #1a1a2e;
            margin-bottom: 10px;
            font-size: 32px;
        }

        .register-box .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 35px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
        }

        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        .form-group input:focus {
            outline: none;
            border-color: #e94560;
        }

        .form-group.error input {
            border-color: #d32f2f;
        }

        .error-text {
            color: #d32f2f;
            font-size: 14px;
            margin-top: 5px;
        }

        .btn-register {
            width: 100%;
            padding: 15px;
            background: #e94560;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px;
        }

        .btn-register:hover {
            background: #d63850;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(233, 69, 96, 0.3);
        }

        .login-link {
            text-align: center;
            margin-top: 25px;
            color: #666;
        }

        .login-link a {
            color: #e94560;
            text-decoration: none;
            font-weight: 600;
        }

        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="register-container">
        <div class="register-box">
            <h1>🎼 Înregistrare</h1>
            <p class="subtitle">Creează-ți un cont gratuit</p>

            <form method="POST" action="">
                <div class="form-group <?= isset($errors['username']) ? 'error' : '' ?>">
                    <label for="username">Username *</label>
                    <input type="text" id="username" name="username"
                        value="<?= $_POST['username'] ?? '' ?>" required>
                    <?php if (isset($errors['username'])): ?>
                        <div class="error-text"><?= $errors['username'] ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group <?= isset($errors['email']) ? 'error' : '' ?>">
                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email"
                        value="<?= $_POST['email'] ?? '' ?>" required>
                    <?php if (isset($errors['email'])): ?>
                        <div class="error-text"><?= $errors['email'] ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group <?= isset($errors['full_name']) ? 'error' : '' ?>">
                    <label for="full_name">Nume complet *</label>
                    <input type="text" id="full_name" name="full_name"
                        value="<?= $_POST['full_name'] ?? '' ?>" required>
                    <?php if (isset($errors['full_name'])): ?>
                        <div class="error-text"><?= $errors['full_name'] ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group <?= isset($errors['password']) ? 'error' : '' ?>">
                    <label for="password">Parolă *</label>
                    <input type="password" id="password" name="password" required>
                    <?php if (isset($errors['password'])): ?>
                        <div class="error-text"><?= $errors['password'] ?></div>
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn-register">Înregistrare</button>
            </form>

            <div class="login-link">
                Ai deja cont? <a href="login.php">Conectează-te</a>
            </div>
        </div>
    </div>
</body>

</html>