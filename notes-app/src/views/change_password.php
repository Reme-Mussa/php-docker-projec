<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ändra lösenord</title>
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
        <h1 class="text-center">Ändra lösenord</h1>
        <?php if ($message): ?>
            <div class="alert <?= strpos($message, 'uppdaterats') !== false ? 'alert-success' : 'alert-error' ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>
        <form method="post" class="note-form">
            <div class="form-group">
                <label for="current_password">Nuvarande lösenord:</label>
                <input type="password" id="current_password" name="current_password" required>
            </div>
            <div class="form-group">
                <label for="new_password">Nytt lösenord:</label>
                <input type="password" id="new_password" name="new_password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Bekräfta nytt lösenord:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn">Uppdatera lösenord</button>
                <a href="/?action=index" class="btn btn-secondary">Avbryt</a>
            </div>
        </form>
    </div>
</body>
</html> 