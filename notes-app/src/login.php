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

    if (empty($username) || empty($password)) {
        $error = 'Vänligen fyll i alla fält';
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header('Location: index.php');
            exit();
        } else {
            $error = 'Felaktigt användarnamn eller lösenord';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logga in</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Logga in</h1>
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

            <button type="submit" class="btn">Logga in</button>
        </form>

        <p style="text-align: center; margin-top: 20px;">
            Har du inget konto? <a href="register.php">Registrera dig</a>
        </p>
    </div>
</body>
</html> 