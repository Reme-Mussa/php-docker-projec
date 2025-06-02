<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skapa ny anteckning</title>
    <link rel="stylesheet" href="/styles.css">
</head>
<body>
    <nav class="nav">
        <div class="container nav-container">
            <h2>Anteckningar</h2>
            <div class="nav-links">
                <a href="/?action=index">Tillbaka till anteckningar</a>
                <a href="/?action=logout">Logga ut</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <h1 class="text-center">Skapa ny anteckning</h1>
        <?php if ($message): ?>
            <div class="alert alert-error"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>
        <form method="post" class="note-form">
            <div class="form-group">
                <label for="title">Titel:</label>
                <input type="text" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="content">Innehåll:</label>
                <textarea id="content" name="content" required></textarea>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn">Skapa anteckning</button>
                <a href="/?action=index" class="btn btn-secondary">Avbryt</a>
            </div>
        </form>
    </div>
</body>
</html> 