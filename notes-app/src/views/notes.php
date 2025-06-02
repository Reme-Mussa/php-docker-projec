<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mina Anteckningar</title>
    <link rel="stylesheet" href="/styles.css">
</head>
<body>
    <nav class="nav">
        <div class="container nav-container">
            <h2>Anteckningar</h2>
            <div class="nav-links">
                <a href="/?action=add">Skapa ny anteckning</a>
                <a href="/?action=change-password">Ändra lösenord</a>
                <a href="/?action=logout">Logga ut</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <h1 class="text-center">Mina Anteckningar</h1>
        
        <?php if (empty($notes)): ?>
            <p class="text-center">Du har inga anteckningar än. <a href="/?action=add">Skapa en ny anteckning</a>.</p>
        <?php else: ?>
            <?php foreach ($notes as $note): ?>
                <div class="note">
                    <h3 class="note-title"><?= htmlspecialchars($note['title']) ?></h3>
                    <div class="note-content"><?= nl2br(htmlspecialchars($note['content'])) ?></div>
                    <div class="note-actions">
                        <a href="/?action=edit&id=<?= $note['id'] ?>" class="btn">Redigera</a>
                        <a href="/?action=delete&id=<?= $note['id'] ?>" class="btn btn-secondary" onclick="return confirm('Är du säker på att du vill ta bort denna anteckning?')">Ta bort</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html> 