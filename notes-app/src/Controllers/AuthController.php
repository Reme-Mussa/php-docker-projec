<?php

namespace App\Controllers;

use PDO;

class AuthController
{
    private PDO $pdo;

    public function __construct()
    {
        require_once __DIR__ . '/../includes/db_connect.php';
        $this->pdo = get_db_connection();
    }

    public function login()
    {
        $message = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = htmlspecialchars(trim($_POST['username'] ?? ''), ENT_QUOTES, 'UTF-8');
            $password = $_POST['password'] ?? '';

            if (empty($username) || empty($password)) {
                $message = 'Vänligen fyll i alla fält.';
            } else {
                $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = ?");
                $stmt->execute([$username]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($user && password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    header("Location: /?action=index");
                    exit;
                } else {
                    $message = 'Felaktigt användarnamn eller lösenord.';
                }
            }
        }

        require __DIR__ . '/../views/login.php';
    }

    public function register()
    {
        $message = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = htmlspecialchars(trim($_POST['username'] ?? ''), ENT_QUOTES, 'UTF-8');
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';

            if (empty($username) || empty($password) || empty($confirm_password)) {
                $message = 'Vänligen fyll i alla fält.';
            } elseif ($password !== $confirm_password) {
                $message = 'Lösenorden matchar inte.';
            } else {
                $stmt = $this->pdo->prepare("SELECT id FROM users WHERE username = ?");
                $stmt->execute([$username]);
                if ($stmt->fetch()) {
                    $message = 'Användarnamnet är redan taget.';
                } else {
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $this->pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
                    if ($stmt->execute([$username, $hashed_password])) {
                        $_SESSION['user_id'] = $this->pdo->lastInsertId();
                        $_SESSION['username'] = $username;
                        header("Location: /?action=index");
                        exit;
                    } else {
                        $message = 'Kunde inte skapa kontot. Försök igen.';
                    }
                }
            }
        }

        require __DIR__ . '/../views/register.php';
    }

    public function logout()
    {
        session_destroy();
        header("Location: /?action=login");
        exit;
    }
} 