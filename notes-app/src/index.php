<?php
require_once __DIR__ . '/includes/db_connect.php';

// إنشاء الجداول إذا لم تكن موجودة
try {
    $pdo = get_db_connection();
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL
    )");

    $pdo->exec("CREATE TABLE IF NOT EXISTS notes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(100) NOT NULL,
        content TEXT NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        user_id INT,
        FOREIGN KEY (user_id) REFERENCES users(id)
    )");
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}

// جلب جميع الملاحظات من قاعدة البيانات
try {
    $pdo = get_db_connection();
    $stmt = $pdo->query("SELECT notes.id, notes.title, notes.content, notes.created_at, users.username 
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
    <a href="../index.php">Home</a>
    <div class="notes-list">
        <?php if ($notes): ?>
            <?php foreach ($notes as $note): ?>
                <div class="note-card">
                    <h2><?= htmlspecialchars($note['title']) ?></h2>
                    <p><?= nl2br(htmlspecialchars($note['content'])) ?></p>
                    <small>By: <?= htmlspecialchars($note['username']) ?> | <?= $note['created_at'] ?></small>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No notes found.</p>
        <?php endif; ?>
    </div>
</body>
</html>