<?php
session_start(); // Start the session at the beginning of this file

require_once __DIR__ . 
'/db_connect.php'; // To use database connection if needed here

/**
 * Checks if the user is currently logged in.
 * @return bool True if the user is logged in, False otherwise.
 */
function is_user_logged_in() {
    return isset($_SESSION['user_id']);
}

/**
 * Requires login to access the page.
 * If the user is not logged in, redirects to the login page.
 */
function require_login() {
    if (!is_user_logged_in()) {
        // Assuming login.php is in the same directory level as the calling page's directory (e.g., pages/)
        // Adjust path if login.php is elsewhere, e.g., "../login.php" if pages are in src/pages/
        // or pass the path as an argument.
        header("Location: login.php"); 
        exit;
    }
}

/**
 * Logs out the current user.
 */
function logout_user() {
    session_unset();
    session_destroy();
    header("Location: login.php"); // Or notes.php as preferred
    exit;
}

/**
 * Gets the ID of the currently logged-in user.
 * @return int|null User ID or null if not logged in.
 */
function get_current_user_id() {
    return $_SESSION['user_id'] ?? null;
}

/**
 * Gets the username of the currently logged-in user.
 * @return string|null Username or null if not logged in.
 */
function get_current_username() {
    return $_SESSION['username'] ?? null;
}

// You can add other authentication-related functions here if needed,
// e.g., a function to register a new user (moving logic from register.php here),
// or a function to log in a user (moving logic from login.php here).
// This would make register.php and login.php just UIs calling these functions.

?>
