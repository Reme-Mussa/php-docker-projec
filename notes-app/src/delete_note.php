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
    $note_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

    if (!$note_id) {
        throw new Exception("Invalid note ID.");
    }

    // Verify note exists and belongs to user
    $stmt = $pdo->prepare("SELECT id FROM notes WHERE id = :id AND user_id = :user_id");
    $stmt->bindParam(':id', $note_id, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt->execute();

    if (!$stmt->fetch()) {
        throw new Exception("Note not found or you don't have permission to delete it.");
    }

    // Delete the note
    $stmt = $pdo->prepare("DELETE FROM notes WHERE id = :id AND user_id = :user_id");
    $stmt->bindParam(':id', $note_id, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
    
    if (!$stmt->execute()) {
        throw new Exception("Failed to delete note.");
    }

    $_SESSION['message'] = "Note deleted successfully.";
} catch (Exception $e) {
    error_log("Delete note error: " . $e->getMessage());
    $_SESSION['error'] = "An error occurred while deleting the note.";
}

header("Location: notes.php");
exit;