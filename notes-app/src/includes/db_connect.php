<?php
// Database connection for notes-app
function get_db_connection() {
    $host = 'db';
    $dbname = 'notes_db';
    $username = 'notes_user';
    $password = 'notes_password';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    }
}