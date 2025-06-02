<?php

session_start();
require __DIR__ . '/../vendor/autoload.php';

use App\Controllers\NoteController;
use App\Controllers\AuthController;
use App\Controllers\UserController;

$noteController = new NoteController();
$authController = new AuthController();
$userController = new UserController();

// Simple routing
$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'login':
        $authController->login();
        break;
    case 'register':
        $authController->register();
        break;
    case 'logout':
        $authController->logout();
        break;
    case 'change-password':
        $userController->changePassword();
        break;
    case 'edit':
        $noteController->edit();
        break;
    case 'add':
        $noteController->add();
        break;
    case 'delete':
        $noteController->delete();
        break;
    default:
        $noteController->index();
        break;
} 