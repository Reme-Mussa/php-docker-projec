<?php
require_once __DIR__ . '/includes/db_connect.php';
session_start();

try {
    $pdo = get_db_connection();

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) UNIQUE NOT NULL,
            password VARCHAR(255) NOT NULL
        );
        CREATE TABLE IF NOT EXISTS notes (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(100) NOT NULL,
            content TEXT NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            user_id INT,
            FOREIGN KEY (user_id) REFERENCES users(id)
        );
    ");

    $stmt = $pdo->query("
        SELECT notes.id, notes.title, notes.content, notes.created_at, users.username 
        FROM notes 
        JOIN users ON notes.user_id = users.id
        ORDER BY notes.created_at DESC
    ");
    $notes = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Notes List</title>
    <link rel="stylesheet" href="../styles.css" />
    <style>
        body {
            background-image: url('https://www.transparenttextures.com/patterns/gray-floral.png');
            background-repeat: repeat;
        }
        .note-card {
            display: flex;
            gap: 1rem;
            align-items: flex-start;
            background: linear-gradient(to bottom right, #ffffff, #eef3f7);
            border: 1px solid #ddd;
            padding: 16px;
            border-radius: 10px;
            margin-bottom: 16px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .note-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 6px;
        }
        .note-content {
            flex: 1;
        }
        .note-content h2 {
            margin-top: 0;
            color: #34495e;
        }
        .note-content p {
            color: #555;
            margin: 8px 0;
        }
        .note-content small {
            color: #888;
            display: block;
            margin-top: 10px;
        }
        @media (max-width: 768px) {
            .note-card {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }
            .note-image {
                margin-bottom: 12px;
            }
        }
        a.btn {
            display: inline-block;
            padding: 10px 16px;
            background-color: #3498db;
            color: white;
            border-radius: 6px;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        a.btn:hover {
            background-color: #2980b9;
        }
        .text-center {
            text-align: center;
        }
        .mt-2 {
            margin-top: 1rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center">All Notes</h1>
        <div class="text-center mt-2">
            <a href="../index.php" class="btn">Home</a>
        </div>
        <div class="notes-list mt-2">
            <?php if ($notes): ?>
                <?php foreach ($notes as $note): ?>
                    <div class="note-card">
                        <img src="https://picsum.photos/seed/<?= $note['id'] ?>/100" alt="Note image" class="note-image" />
                        <div class="note-content">
                            <h2><?= htmlspecialchars($note['title']) ?></h2>
                            <p><?= nl2br(htmlspecialchars($note['content'])) ?></p>
                            <small>By: <?= htmlspecialchars($note['username']) ?> | <?= htmlspecialchars($note['created_at']) ?></small>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center">No notes found.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>