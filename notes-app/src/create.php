<?php
session_start();
require_once 'includes/db_connect.php';
require_once 'includes/functions.php';

// التحقق من تسجيل الدخول
if (!is_logged_in()) {
    header('Location: login.php');
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = clean_input($_POST['title'] ?? '');
    $content = clean_input($_POST['content'] ?? '');

    if (empty($title) || empty($content)) {
        $error = 'Vänligen fyll i både titel och innehåll';
    } else {
        $stmt = $pdo->prepare("INSERT INTO notes (user_id, title, content) VALUES (?, ?, ?)");
        
        if ($stmt->execute([$_SESSION['user_id'], $title, $content])) {
            $_SESSION['success'] = 'Anteckningen har skapats';
            header('Location: index.php');
            exit();
        } else {
            $error = 'Ett fel uppstod vid skapandet av anteckningen';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skapa ny anteckning</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Skapa ny anteckning</h1>
            <nav>
                <a href="index.php" class="btn">Tillbaka</a>
            </nav>
        </header>

        <?php if ($error): ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>

        <form class="auth-form" method="POST" action="">
            <div class="form-group">
                <label for="title">Titel:</label>
                <input type="text" id="title" name="title" required>
            </div>

            <div class="form-group">
                <label for="content">Innehåll:</label>
                <textarea id="content" name="content" rows="6" required></textarea>
            </div>

            <button type="submit" class="btn">Skapa anteckning</button>
        </form>
    </div>
</body>
</html> 