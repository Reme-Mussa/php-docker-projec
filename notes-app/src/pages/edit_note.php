<?php
require_once __DIR__ . '/../includes/db_connect.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$pdo = get_db_connection();
$message = '';
$note_id = $_GET['id'] ?? null;

// جلب بيانات الملاحظة
if ($note_id) {
    $stmt = $pdo->prepare("SELECT * FROM notes WHERE id = ? AND user_id = ?");
    $stmt->execute([$note_id, $_SESSION['user_id']]);
    $note = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$note) {
        die("Note not found or you don't have permission.");
    }
} else {
    die("No note id.");
}

// عند إرسال النموذج
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');

    if ($title === '' || $content === '') {
        $message = 'Please fill in all fields.';
    } else {
        $stmt = $pdo->prepare("UPDATE notes SET title = ?, content = ? WHERE id = ? AND user_id = ?");
        if ($stmt->execute([$title, $content, $note_id, $_SESSION['user_id']])) {
            header("Location: notes.php");
            exit;
        } else {
            $message = 'Failed to update note.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Note</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <h1>Edit Note</h1>
    <?php if ($message): ?>
        <div class="message"><?= $message ?></div>
    <?php endif; ?>
    <form method="post">
        <label>Title:</label>
        <input type="text" name="title" value="<?= htmlspecialchars($note['title']) ?>" required>
        <label>Content:</label>
        <textarea name="content" required><?= htmlspecialchars($note['content']) ?></textarea>
        <button type="submit">Update Note</button>
    </form>
    <p><a href="notes.php">Back to notes</a></p>
</body>
</html>