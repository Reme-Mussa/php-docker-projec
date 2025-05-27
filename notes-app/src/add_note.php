<?php
require_once __DIR__ . '/includes/db_connect.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

try {
    $pdo = get_db_connection();

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = trim($_POST['title'] ?? '');
        $content = trim($_POST['content'] ?? '');
        $user_id = $_SESSION['user_id'];

        if (!empty($title) && !empty($content)) {
            // Insert new note with named parameters
            $stmt = $pdo->prepare("INSERT INTO notes (title, content, user_id) VALUES (:title, :content, :user_id)");
            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt->bindParam(':content', $content, PDO::PARAM_STR);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            
            if ($stmt->execute()) {
                header("Location: notes.php");
                exit;
            } else {
                $error = "Failed to create note. Please try again.";
            }
        } else {
            $error = "Please fill in all fields.";
        }
    }
} catch (PDOException $e) {
    $error = "An error occurred. Please try again later.";
    // Log the error for debugging
    error_log("Add note error: " . $e->getMessage());
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