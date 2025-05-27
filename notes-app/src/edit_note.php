<?php
require_once __DIR__ . '/includes/db_connect.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$pdo = get_db_connection();
$message = '';
$note_id = $_GET['id'] ?? null;

// Fetch note data
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

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim(filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING));
    $content = trim(filter_input(INPUT_POST, 'content', FILTER_SANITIZE_STRING));

    if (empty($title) || empty($content)) {
        $message = 'Please fill in all fields.';
    } else {
        $stmt = $pdo->prepare("UPDATE notes SET title = :title, content = :content WHERE id = :id AND user_id = :user_id");
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':content', $content, PDO::PARAM_STR);
        $stmt->bindParam(':id', $note_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            header("Location: notes.php");
            exit;
        } else {
            $message = 'Failed to update note. Please try again.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Note</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <div class="container">
        <h1 class="text-center">Edit Note</h1>
        <?php if ($message): ?>
            <div class="alert alert-error"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>
        <form method="post" class="note-form">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" value="<?= htmlspecialchars($note['title']) ?>" required>
            </div>
            <div class="form-group">
                <label for="content">Content:</label>
                <textarea id="content" name="content" required><?= htmlspecialchars($note['content']) ?></textarea>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn">Update Note</button>
                <a href="notes.php" class="btn btn-secondary">Back to Notes</a>
            </div>
        </form>
    </div>
</body>
</html>