<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logga in</title>
    <link rel="stylesheet" href="/styles.css">
</head>
<body>
    <div class="container">
        <h1 class="text-center">Logga in</h1>
        <?php if ($message): ?>
            <div class="alert alert-error"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>
        <form method="post" class="note-form">
            <div class="form-group">
                <label for="username">Användarnamn:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Lösenord:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn">Logga in</button>
                <a href="/?action=register" class="btn btn-secondary">Registrera nytt konto</a>
            </div>
        </form>
    </div>
</body>
</html> 