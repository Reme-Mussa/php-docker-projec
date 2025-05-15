<?php
require_once __DIR__ . '/../includes/db_connect.php';
session_start();

try {
    $pdo = get_db_connection();

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = $_POST['title'] ?? '';
        $content = $_POST['content'] ?? '';
        $user_id = 1; // Replace with actual logged-in user ID in real case

        if (!empty($title) && !empty($content)) {
            $stmt = $pdo->prepare("INSERT INTO notes (title, content, user_id) VALUES (?, ?, ?)");
            $stmt->execute([$title, $content, $user_id]);
            header("Location: notes.php");
            exit;
        } else {
            $error = "Please fill in all fields.";
        }
    }
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Add Note</title>
    <link rel="stylesheet" href="../styles.css" />
</head>
<body>
    <div class="container">
        <h1 class="text-center">Add a New Note</h1>
        <div class="text-center mt-2">
            <a href="notes.php" class="btn">Back to Notes</a>
        </div>

        <?php if (!empty($error)): ?>
            <p style="color: red; text-align: center;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="POST" action="" class="mt-2" style="max-width: 600px; margin: 0 auto;">
            <div style="margin-bottom: 1rem;">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" required style="width: 100%; padding: 8px;">
            </div>
            <div style="margin-bottom: 1rem;">
                <label for="content">Content:</label>
                <textarea id="content" name="content" rows="6" required style="width: 100%; padding: 8px;"></textarea>
            </div>
            <div style="text-align: center;">
                <button type="submit" class="btn">Add Note</button>
            </div>
        </form>
    </div>
</body>
</html>