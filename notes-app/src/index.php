<?php
session_start();
require_once 'includes/db_connect.php';
require_once 'includes/functions.php';

// التحقق من تسجيل الدخول
if (!is_logged_in()) {
    header('Location: login.php');
    exit();
}

// جلب الملاحظات
$stmt = $pdo->prepare("SELECT * FROM notes WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$_SESSION['user_id']]);
$notes = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mina anteckningar</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Mina anteckningar</h1>
            <nav>
                <a href="create.php" class="btn">Lägg till ny anteckning</a>
                <a href="logout.php" class="btn">Logga ut</a>
            </nav>
        </header>

        <?php show_messages(); ?>

        <div class="notes">
            <?php if (empty($notes)): ?>
                <p>Du har inga anteckningar än.</p>
            <?php else: ?>
                <?php foreach ($notes as $note): ?>
                    <div class="note">
                        <h2><?php echo htmlspecialchars($note['title']); ?></h2>
                        <p><?php echo nl2br(htmlspecialchars($note['content'])); ?></p>
                        <div class="note-actions">
                            <a href="edit.php?id=<?php echo $note['id']; ?>" class="btn">Redigera</a>
                            <a href="delete.php?id=<?php echo $note['id']; ?>" class="btn" onclick="return confirm('Är du säker på att du vill ta bort denna anteckning?')">Ta bort</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html> 