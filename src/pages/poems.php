<?php
require_once '../includes/auth.php';
require_once '../includes/db_connect.php';

redirectIfNotLoggedIn();

$stmt = $pdo->query("SELECT * FROM poems");
$poems = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html dir="rtl">
<head>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <?php foreach ($poems as $poem): ?>
    <div class="poem-card">
        <h3><?= htmlspecialchars($poem['title']) ?></h3>
        <p><?= nl2br(htmlspecialchars($poem['content'])) ?></p>
        <?php if (isCurrentUser($poem['user_id'])): ?>
            <a href="edit_poem.php?id=<?= $poem['id'] ?>">تعديل</a>
        <?php endif; ?>
    </div>
    <?php endforeach; ?>
</body>
</html>