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
$note = null;

// التحقق من وجود معرف الملاحظة
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$note_id = (int)$_GET['id'];

// التحقق من ملكية الملاحظة
if (!is_note_owner($note_id)) {
    header('Location: index.php');
    exit();
}

// جلب بيانات الملاحظة
$stmt = $pdo->prepare("SELECT * FROM notes WHERE id = ? AND user_id = ?");
$stmt->execute([$note_id, $_SESSION['user_id']]);
$note = $stmt->fetch();

if (!$note) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = clean_input($_POST['title'] ?? '');
    $content = clean_input($_POST['content'] ?? '');

    if (empty($title) || empty($content)) {
        $error = 'Vänligen fyll i både titel och innehåll';
    } else {
        $stmt = $pdo->prepare("UPDATE notes SET title = ?, content = ? WHERE id = ? AND user_id = ?");
        
        if ($stmt->execute([$title, $content, $note_id, $_SESSION['user_id']])) {
            $_SESSION['success'] = 'Anteckningen har uppdaterats';
            header('Location: index.php');
            exit();
        } else {
            $error = 'Ett fel uppstod vid uppdateringen av anteckningen';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redigera anteckning</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Redigera anteckning</h1>
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
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($note['title']); ?>" required>
            </div>

            <div class="form-group">
                <label for="content">Innehåll:</label>
                <textarea id="content" name="content" rows="6" required><?php echo htmlspecialchars($note['content']); ?></textarea>
            </div>

            <button type="submit" class="btn">Uppdatera anteckning</button>
        </form>
    </div>
</body>
</html> 