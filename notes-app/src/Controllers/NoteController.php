<?php

namespace App\Controllers;

use PDO;

class NoteController
{
    private PDO $pdo;

    public function __construct()
    {
        require_once __DIR__ . '/../includes/db_connect.php';
        $this->pdo = get_db_connection();
    }

    public function index()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /?action=login");
            exit;
        }

        $stmt = $this->pdo->prepare("SELECT * FROM notes WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->execute([$_SESSION['user_id']]);
        $notes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require __DIR__ . '/../views/notes.php';
    }

    public function add()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /?action=login");
            exit;
        }

        $message = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = htmlspecialchars(trim($_POST['title'] ?? ''), ENT_QUOTES, 'UTF-8');
            $content = htmlspecialchars(trim($_POST['content'] ?? ''), ENT_QUOTES, 'UTF-8');

            if (empty($title) || empty($content)) {
                $message = 'Vänligen fyll i alla fält.';
            } else {
                $stmt = $this->pdo->prepare("INSERT INTO notes (user_id, title, content) VALUES (?, ?, ?)");
                if ($stmt->execute([$_SESSION['user_id'], $title, $content])) {
                    header("Location: /?action=index");
                    exit;
                } else {
                    $message = 'Kunde inte skapa anteckningen. Försök igen.';
                }
            }
        }

        require __DIR__ . '/../views/add_note.php';
    }

    public function edit()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /?action=login");
            exit;
        }

        $note_id = $_GET['id'] ?? null;
        $message = '';

        if ($note_id) {
            $stmt = $this->pdo->prepare("SELECT * FROM notes WHERE id = ? AND user_id = ?");
            $stmt->execute([$note_id, $_SESSION['user_id']]);
            $note = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$note) {
                die("Anteckningen hittades inte eller du har inte behörighet.");
            }
        } else {
            die("Inget antecknings-ID angivet.");
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = htmlspecialchars(trim($_POST['title'] ?? ''), ENT_QUOTES, 'UTF-8');
            $content = htmlspecialchars(trim($_POST['content'] ?? ''), ENT_QUOTES, 'UTF-8');

            if (empty($title) || empty($content)) {
                $message = 'Vänligen fyll i alla fält.';
            } else {
                $stmt = $this->pdo->prepare("UPDATE notes SET title = :title, content = :content WHERE id = :id AND user_id = :user_id");
                $stmt->bindParam(':title', $title, PDO::PARAM_STR);
                $stmt->bindParam(':content', $content, PDO::PARAM_STR);
                $stmt->bindParam(':id', $note_id, PDO::PARAM_INT);
                $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
                
                if ($stmt->execute()) {
                    header("Location: /?action=index");
                    exit;
                } else {
                    $message = 'Kunde inte uppdatera anteckningen. Försök igen.';
                }
            }
        }

        require __DIR__ . '/../views/edit_note.php';
    }

    public function delete()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /?action=login");
            exit;
        }

        $note_id = $_GET['id'] ?? null;

        if ($note_id) {
            $stmt = $this->pdo->prepare("DELETE FROM notes WHERE id = ? AND user_id = ?");
            if ($stmt->execute([$note_id, $_SESSION['user_id']])) {
                header("Location: /?action=index");
                exit;
            }
        }

        die("Kunde inte ta bort anteckningen.");
    }
} 