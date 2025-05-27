<?php
function get_db_connection() {
    $host = 'db';
    $dbname = 'notes_db';
    $username = 'notes_user';
    $password = 'notes_password';

    try {
        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
        ];

        $pdo = new PDO($dsn, $username, $password, $options);
        return $pdo;
    } catch (PDOException $e) {
        // Log the error but don't expose details to the user
        error_log("Database connection error: " . $e->getMessage());
        throw new Exception("Database connection failed. Please try again later.");
    }
}