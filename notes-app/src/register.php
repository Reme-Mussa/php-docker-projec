<?php
require_once __DIR__ . '/includes/db_connect.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username === '' || $password === '') {
        $message = 'Please fill in all fields.';
    } elseif (strlen($password) < 6) {
        $message = 'Password must be at least 6 characters.';
    } else {
        try {
            $pdo = get_db_connection();
            
            // Check if username exists using named parameter
            $stmt = $pdo->prepare("SELECT id FROM users WHERE username = :username");
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();
            
            if ($stmt->fetch()) {
                $message = 'Username already exists.';
            } else {
                $hashed = password_hash($password, PASSWORD_DEFAULT);
                
                // Insert new user with named parameters
                $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
                $stmt->bindParam(':username', $username, PDO::PARAM_STR);
                $stmt->bindParam(':password', $hashed, PDO::PARAM_STR);
                
                if ($stmt->execute()) {
                    $message = 'Registration successful! You can now <a href="login.php">login</a>.';
                } else {
                    $message = 'Registration failed. Try again.';
                }
            }
        } catch (PDOException $e) {
            $message = 'An error occurred. Please try again later.';
            // Log the error for debugging
            error_log("Registration error: " . $e->getMessage());
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <h1>Register</h1>
    <?php if ($message): ?>
        <div class="message"><?= $message ?></div>
    <?php endif; ?>
    <form method="post">
        <label>Username:</label>
        <input type="text" name="username" required>
        <label>Password:</label>
        <input type="password" name="password" required>
        <button type="submit">Register</button>
    </form>
    <p>Already have an account? <a href="login.php">Login here</a>.</p>
    <p><a href="notes.php">Back to notes</a></p>
</body>
</html>