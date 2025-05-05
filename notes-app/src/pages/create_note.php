<?php
require_once __DIR__ . '/../includes/db_connect.php';
session_start();

// إذا لم يكن المستخدم مسجل دخول، إعادة توجيه
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');

    if ($title === '' || $content === '') {
        $message = 'Please fill in all fields.';
    } else {
        $pdo = get_db_connection();
        $stmt = $pdo->prepare("INSERT INTO notes (title, content, user_id) VALUES (?, ?, ?)");
        if ($stmt->execute([$title, $content, $_SESSION['user_id']])) {
            header("Location: notes.php");
            exit;
        } else {
            $message = 'Failed to add note.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Note</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <h1>Create New Note</h1>
    <?php if ($message): ?>
        <div class="message"><?= $message ?></div>
    <?php endif; ?>
    <form method="post">
        <label>Title:</label>
        <input type="text" name="title" required>
        <label>Content:</label>
        <textarea name="content" required></textarea>
        <button type="submit">Add Note</button>
    </form>
    <p><a href="notes.php">Back to notes</a></p>
</body>
</html>