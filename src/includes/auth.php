<?php
session_start();

function redirectIfNotLoggedIn() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: /pages/login.php");
        exit();
    }
}

function isCurrentUser($user_id) {
    return $_SESSION['user_id'] == $user_id;
}
?>