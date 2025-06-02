<?php
try {
    $pdo = new PDO(
        "mysql:host=db;dbname=notes_db",
        "notes_user",
        "notes_password"
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Kunde inte ansluta till databasen: " . $e->getMessage());
}