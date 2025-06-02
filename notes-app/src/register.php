<?php
session_start();
require_once 'includes/db_connect.php';
require_once 'includes/functions.php';

// إذا كان المستخدم مسجل الدخول بالفعل
if (is_logged_in()) {
    header('Location: index.php');
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = clean_input($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (empty($username) || empty($password) || empty($confirm_password)) {
        $error = 'Vänligen fyll i alla fält';
    } elseif ($password !== $confirm_password) {
        $error = 'Lösenorden matchar inte';
    } elseif (strlen($password) < 6) {
        $error = 'Lösenordet måste vara minst 6 tecken långt';
    } else {
        // التحقق من وجود اسم المستخدم
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            $error = 'Användarnamnet är redan taget';
        } else {
            // إنشاء المستخدم الجديد
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            
            if ($stmt->execute([$username, $hashed_password])) {
                $_SESSION['user_id'] = $pdo->lastInsertId();
                $_SESSION['username'] = $username;
                header('Location: index.php');
                exit();
            } else {
                $error = 'Ett fel uppstod vid registreringen';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrera dig</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Registrera dig</h1>
        </header>

        <?php if ($error): ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>

        <form class="auth-form" method="POST" action="">
            <div class="form-group">
                <label for="username">Användarnamn:</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="form-group">
                <label for="password">Lösenord:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <label for="confirm_password">Bekräfta lösenord:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>

            <button type="submit" class="btn">Registrera</button>
        </form>

        <p style="text-align: center; margin-top: 20px;">
            Har du redan ett konto? <a href="login.php">Logga in</a>
        </p>
    </div>
</body>
</html> 