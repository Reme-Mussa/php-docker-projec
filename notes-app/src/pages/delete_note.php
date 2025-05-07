<?php
require_once __DIR__ . '/../includes/db_connect.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$note_id = $_GET['id'] ?? null;

if ($note_id) {
    $pdo = get_db_connection();
    $stmt = $pdo->prepare("DELETE FROM notes WHERE id = ? AND user_id = ?");
    $stmt->execute([$note_id, $_SESSION['user_id']]);
}

header("Location: notes.php");
exit;