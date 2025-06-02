<?php
try {
    $pdo = new PDO(
        "mysql:host=db;dbname=notes_db;charset=utf8mb4",
        "notes_user",
        "notes_password",
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
} catch (PDOException $e) {
    die("Databasanslutning misslyckades: " . $e->getMessage());
}