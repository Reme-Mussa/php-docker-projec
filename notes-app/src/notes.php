<?php
require_once __DIR__ . '/includes/db_connect.php';
session_start();

try {
    $pdo = get_db_connection();
    $stmt = $pdo->query("SELECT notes.id, notes.title, notes.content, notes.created_at, users.username, notes.user_id 
                         FROM notes 
                         JOIN users ON notes.user_id = users.id
                         ORDER BY notes.created_at DESC");
    $notes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    $error = "An error occurred while fetching notes.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notes</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <?php if (isset($_SESSION['user_id'])): ?>
            <div class="user-nav">
                <p>Welcome, <?= htmlspecialchars($_SESSION['username']) ?></p>
                <div class="nav-buttons">
                    <a href="add_note.php" class="btn">Add Note</a>
                    <a href="logout.php" class="btn">Logout</a>
                </div>
            </div>
        <?php else: ?>
            <div class="user-nav">
                <div class="nav-buttons">
                    <a href="register.php" class="btn">Register</a>
                    <a href="login.php" class="btn">Login</a>
                </div>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-success">
                <?= htmlspecialchars($_SESSION['message']) ?>
                <?php unset($_SESSION['message']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error">
                <?= htmlspecialchars($_SESSION['error']) ?>
                <?php unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($error)): ?>
            <div class="alert alert-error">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <h1 class="text-center">All Notes</h1>

        <div class="notes-list">
            <?php if ($notes): ?>
                <?php foreach ($notes as $note): ?>
                    <div class="note-card">
                        <h2><?= htmlspecialchars($note['title']) ?></h2>
                        <p><?= nl2br(htmlspecialchars($note['content'])) ?></p>
                        <div class="note-meta">
                            <small>By: <?= htmlspecialchars($note['username']) ?> | <?= date('Y-m-d H:i', strtotime($note['created_at'])) ?></small>
                        </div>
                        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $note['user_id']): ?>
                            <div class="note-actions">
                                <a href="edit_note.php?id=<?= $note['id'] ?>" class="btn btn-small">Edit</a>
                                <a href="delete_note.php?id=<?= $note['id'] ?>" class="btn btn-small btn-danger" 
                                   onclick="return confirm('Are you sure you want to delete this note?')">Delete</a>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center">No notes found.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>