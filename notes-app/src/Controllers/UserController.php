<?php

namespace App\Controllers;

use PDO;

class UserController
{
    private PDO $pdo;

    public function __construct()
    {
        require_once __DIR__ . '/../includes/db_connect.php';
        $this->pdo = get_db_connection();
    }

    public function changePassword()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /?action=login");
            exit;
        }

        $message = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $current_password = $_POST['current_password'] ?? '';
            $new_password = $_POST['new_password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';

            if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
                $message = 'Vänligen fyll i alla fält.';
            } elseif ($new_password !== $confirm_password) {
                $message = 'De nya lösenorden matchar inte.';
            } else {
                $stmt = $this->pdo->prepare("SELECT password FROM users WHERE id = ?");
                $stmt->execute([$_SESSION['user_id']]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($user && password_verify($current_password, $user['password'])) {
                    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                    $stmt = $this->pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
                    if ($stmt->execute([$hashed_password, $_SESSION['user_id']])) {
                        $message = 'Lösenordet har uppdaterats.';
                    } else {
                        $message = 'Kunde inte uppdatera lösenordet. Försök igen.';
                    }
                } else {
                    $message = 'Nuvarande lösenord är felaktigt.';
                }
            }
        }

        require __DIR__ . '/../views/change_password.php';
    }
} 