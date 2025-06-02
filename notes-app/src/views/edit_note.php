<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redigera Anteckning</title>
    <link rel="stylesheet" href="/styles.css">
</head>
<body>
    <div class="container">
        <h1 class="text-center">Redigera Anteckning</h1>
        <?php if ($message): ?>
            <div class="alert alert-error"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>
        <form method="post" class="note-form">
            <div class="form-group">
                <label for="title">Titel:</label>
                <input type="text" id="title" name="title" value="<?= htmlspecialchars($note['title']) ?>" required>
            </div>
            <div class="form-group">
                <label for="content">Innehåll:</label>
                <textarea id="content" name="content" required><?= htmlspecialchars($note['content']) ?></textarea>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn">Uppdatera Anteckning</button>
                <a href="/?action=index" class="btn btn-secondary">Tillbaka till Anteckningar</a>
            </div>
        </form>
    </div>
</body>
</html> 