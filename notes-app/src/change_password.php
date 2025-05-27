<?php
require_once 'includes/functions.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentPassword = $_POST['current_password'] ?? '';
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
        $error = 'جميع الحقول مطلوبة';
    } elseif ($newPassword !== $confirmPassword) {
        $error = 'كلمات المرور الجديدة غير متطابقة';
    } elseif (strlen($newPassword) < 8) {
        $error = 'يجب أن تكون كلمة المرور الجديدة 8 أحرف على الأقل';
    } else {
        if (verifyCurrentPassword($_SESSION['user_id'], $currentPassword)) {
            if (updatePassword($_SESSION['user_id'], $newPassword)) {
                $success = 'تم تغيير كلمة المرور بنجاح';
            } else {
                $error = 'حدث خطأ أثناء تحديث كلمة المرور';
            }
        } else {
            $error = 'كلمة المرور الحالية غير صحيحة';
        }
    }
}
?>
<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تغيير كلمة المرور</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>تغيير كلمة المرور</h1>
        
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>

        <form method="POST" class="form">
            <div class="form-group">
                <label for="current_password">كلمة المرور الحالية:</label>
                <input type="password" id="current_password" name="current_password" required>
            </div>

            <div class="form-group">
                <label for="new_password">كلمة المرور الجديدة:</label>
                <input type="password" id="new_password" name="new_password" required>
            </div>

            <div class="form-group">
                <label for="confirm_password">تأكيد كلمة المرور الجديدة:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>

            <button type="submit" class="btn btn-primary">تغيير كلمة المرور</button>
        </form>

        <div class="links">
            <a href="notes.php">العودة إلى الملاحظات</a>
        </div>
    </div>
</body>
</html> 