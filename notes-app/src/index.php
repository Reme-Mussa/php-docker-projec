<?php
require_once __DIR__ . '/includes/db_connect.php';
session_start();

// Get statistics
try {
    $pdo = get_db_connection();
    
    // Get total notes count
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM notes");
    $total_notes = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    // Get total users count
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM users");
    $total_users = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    // Get latest notes
    $stmt = $pdo->query("SELECT n.title, n.created_at, u.username 
                        FROM notes n 
                        JOIN users u ON n.user_id = u.id 
                        ORDER BY n.created_at DESC 
                        LIMIT 5");
    $latest_notes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    $total_notes = 0;
    $total_users = 0;
    $latest_notes = [];
}
?>

<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Välkommen till Notes App</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <header class="main-header">
            <h1>Välkommen till Notes App</h1>
            <p class="subtitle">En enkel och säker applikation för att hantera dina anteckningar</p>
        </header>

        <nav class="main-nav">
            <?php if (isset($_SESSION['user_id'])): ?>
                <p class="welcome-message">Välkommen, <?= htmlspecialchars($_SESSION['username']) ?>!</p>
                <div class="nav-buttons">
                    <a href="notes.php" class="btn">Visa alla anteckningar</a>
                    <a href="add_note.php" class="btn">Skapa ny anteckning</a>
                    <a href="logout.php" class="btn">Logga ut</a>
                </div>
            <?php else: ?>
                <div class="nav-buttons">
                    <a href="notes.php" class="btn">Visa alla anteckningar</a>
                    <a href="login.php" class="btn">Logga in</a>
                    <a href="register.php" class="btn">Registrera</a>
                </div>
            <?php endif; ?>
        </nav>

        <main class="main-content">
            <section class="statistics">
                <h2>Statistik</h2>
                <div class="stats-grid">
                    <div class="stat-box">
                        <h3>Anteckningar</h3>
                        <p class="stat-number"><?= $total_notes ?></p>
                    </div>
                    <div class="stat-box">
                        <h3>Användare</h3>
                        <p class="stat-number"><?= $total_users ?></p>
                    </div>
                </div>
            </section>

            <?php if (!empty($latest_notes)): ?>
            <section class="latest-notes">
                <h2>Senaste anteckningarna</h2>
                <div class="notes-grid">
                    <?php foreach ($latest_notes as $note): ?>
                        <div class="note-card">
                            <h3><?= htmlspecialchars($note['title']) ?></h3>
                            <p class="note-meta">
                                Av: <?= htmlspecialchars($note['username']) ?><br>
                                <?= date('Y-m-d H:i', strtotime($note['created_at'])) ?>
                            </p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
            <?php endif; ?>

            <section class="features">
                <h2>Funktioner</h2>
                <div class="features-grid">
                    <div class="feature-box">
                        <h3>Skapa anteckningar</h3>
                        <p>Skapa och hantera dina anteckningar enkelt och säkert.</p>
                    </div>
                    <div class="feature-box">
                        <h3>Säker åtkomst</h3>
                        <p>Endast du kan redigera och ta bort dina egna anteckningar.</p>
                    </div>
                    <div class="feature-box">
                        <h3>Enkel användning</h3>
                        <p>Intuitivt gränssnitt för enkel hantering av anteckningar.</p>
                    </div>
                </div>
            </section>
        </main>

        <footer class="main-footer">
            <p>&copy; <?= date('Y') ?> Notes App. Alla rättigheter förbehållna.</p>
        </footer>
    </div>
</body>
</html>