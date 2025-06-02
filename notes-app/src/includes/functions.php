<?php
require_once __DIR__ . '/db_connect.php';
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// التحقق من تسجيل الدخول
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

// Verify current password
function verifyCurrentPassword($userId, $currentPassword) {
    try {
        $pdo = get_db_connection();
        
        $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch();
        
        if ($user) {
            return password_verify($currentPassword, $user['password']);
        }
        
        return false;
    } catch (PDOException $e) {
        error_log("Password verification error: " . $e->getMessage());
        return false;
    }
}

// Update password
function updatePassword($userId, $newPassword) {
    try {
        $pdo = get_db_connection();
        
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        
        $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
        return $stmt->execute([$hashedPassword, $userId]);
    } catch (PDOException $e) {
        error_log("Password update error: " . $e->getMessage());
        return false;
    }
}

// تنظيف المدخلات
function clean_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Validate note input
function validateNoteInput($title, $content) {
    $errors = [];
    
    if (empty($title)) {
        $errors[] = 'Title is required';
    } elseif (strlen($title) > 255) {
        $errors[] = 'Title must be less than 255 characters';
    }
    
    if (empty($content)) {
        $errors[] = 'Content is required';
    }
    
    return $errors;
}

// Set session message
function set_success($message) {
    $_SESSION['success'] = $message;
}

// Get and clear session message
function getMessage() {
    if (isset($_SESSION['message'])) {
        $message = $_SESSION['message'];
        $type = $_SESSION['message_type'] ?? 'success';
        unset($_SESSION['message'], $_SESSION['message_type']);
        return ['message' => $message, 'type' => $type];
    }
    return null;
}

// التحقق من ملكية الملاحظة
function is_note_owner($note_id) {
    global $pdo;
    if (!is_logged_in()) {
        return false;
    }

    $stmt = $pdo->prepare("SELECT user_id FROM notes WHERE id = ?");
    $stmt->execute([$note_id]);
    $note = $stmt->fetch();

    return $note && $note['user_id'] === $_SESSION['user_id'];
}

// التحقق من صحة كلمة المرور
function validate_password($password) {
    return strlen($password) >= 6;
}

// إنشاء رسالة خطأ
function set_error($message) {
    $_SESSION['error'] = $message;
}

// عرض الرسائل
function display_messages() {
    $output = '';
    
    if (isset($_SESSION['error'])) {
        $output .= '<div class="error-message">' . htmlspecialchars($_SESSION['error']) . '</div>';
        unset($_SESSION['error']);
    }
    
    if (isset($_SESSION['success'])) {
        $output .= '<div class="success-message">' . htmlspecialchars($_SESSION['success']) . '</div>';
        unset($_SESSION['success']);
    }
    
    return $output;
}

// تنسيق التاريخ
function format_date($date) {
    return date('Y-m-d H:i', strtotime($date));
}

// التحقق من صحة معرف الملاحظة
function validate_note_id($id) {
    return is_numeric($id) && $id > 0;
}

// التحقق من صحة عنوان الملاحظة
function validate_note_title($title) {
    return !empty($title) && strlen($title) <= 100;
}

// التحقق من صحة محتوى الملاحظة
function validate_note_content($content) {
    return !empty($content);
}

// Validera användarinput
function validate_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Visa felmeddelande
function show_error($message) {
    return '<div class="error-message">' . htmlspecialchars($message) . '</div>';
}

// Visa framgångsmeddelande
function show_success($message) {
    return '<div class="success-message">' . htmlspecialchars($message) . '</div>';
} 