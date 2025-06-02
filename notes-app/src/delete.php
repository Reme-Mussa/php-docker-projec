<?php
session_start();
require_once 'includes/db_connect.php';
require_once 'includes/functions.php';

// التحقق من تسجيل الدخول
if (!is_logged_in()) {
    header('Location: login.php');
    exit();
}

// التحقق من وجود معرف الملاحظة
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$note_id = (int)$_GET['id'];

// التحقق من ملكية الملاحظة
if (!is_note_owner($note_id)) {
    header('Location: index.php');
    exit();
}

// حذف الملاحظة
$stmt = $pdo->prepare("DELETE FROM notes WHERE id = ? AND user_id = ?");
if ($stmt->execute([$note_id, $_SESSION['user_id']])) {
    $_SESSION['success'] = 'Anteckningen har tagits bort';
} else {
    $_SESSION['error'] = 'Ett fel uppstod vid borttagningen av anteckningen';
}

header('Location: index.php');
exit(); 