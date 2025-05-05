<?php
require_once __DIR__ . '/../includes/db_connect.php';
session_start();

// جلب جميع الملاحظات من قاعدة البيانات
try {
    $pdo = get_db_connection();
    $stmt = $pdo->query("SELECT notes.id, notes.title, notes.content, notes.created_at, users.username, notes.user_id 
                         FROM notes 
                         JOIN users ON notes.user_id = users.id
                         ORDER BY notes.created_at DESC");
    $notes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Notes List</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <h1>All Notes</h1>
    <?php if (isset($_SESSION['user_id'])): ?>
        <p>Welcome, <?= htmlspecialchars($_SESSION['username']) ?> | <a href="create_note.php">Add New Note</a> | <a href="logout.php">Logout</a></p>
    <?php else: ?>
        <a href="register.php">Register</a> | <a href="login.php">Login</a>
    <?php endif; ?>
    <div class="notes-list">
        <?php if ($notes): ?>
            <?php foreach ($notes as $note): ?>
                <div class="note-card">
                    <h2><?= htmlspecialchars($note['title']) ?></h2>
                    <p><?= nl2br(htmlspecialchars($note['content'])) ?></p>
                    <small>By: <?= htmlspecialchars($note['username']) ?> | <?= $note['created_at'] ?></small>
                    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $note['user_id']): ?>
                        <div>
                            <a href="edit_note.php?id=<?= $note['id'] ?>">Edit</a>
                            <a href="delete_note.php?id=<?= $note['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No notes found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
<?php
