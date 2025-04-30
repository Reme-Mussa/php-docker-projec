<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Database Connection</title>
</head>
<body>

<h1>Welcome to My PHP Docker Project</h1>

<?php
// Database configuration
$host = 'mysql-container';  // MySQL container name
$db = 'exampledb';          // Database name
$user = 'root';             // Database username
$pass = 'example';          // Database password
$charset = 'utf8mb4';       // Character set

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

try {
    // Try to connect to the database
    $pdo = new PDO($dsn, $user, $pass);
    echo "<p style='color:green;'>✅ Successfully connected to the database!</p>";

    // Query the 'users' table
    $stmt = $pdo->query("SELECT * FROM users;");

    // Display the data in a table
    echo "<table border='1' cellpadding='5'>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
            </tr>";
    
    // Loop through the results and display them
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>
                <td>" . htmlspecialchars($row['id']) . "</td>
                <td>" . htmlspecialchars($row['name']) . "</td>
                <td>" . htmlspecialchars($row['email']) . "</td>
              </tr>";
    }
    echo "</table>";
} catch (PDOException $e) {
    // If there is an error, display it
    echo "<p style='color:red;'>❌ Failed to connect: " . $e->getMessage() . "</p>";
}
?>

</body>
</html>