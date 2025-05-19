<?php

/**
 * Sanitizes a string to prevent XSS.
 * @param string $data The string to sanitize.
 * @return string The sanitized string.
 */
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/**
 * Validates username format.
 * @param string $username The username to validate.
 * @return bool True if valid, False otherwise.
 */
function validate_username($username) {
    return preg_match('/^[a-zA-Z0-9_]{3,20}$/', $username);
}

/**
 * Validates password strength.
 * @param string $password The password to validate.
 * @return bool True if valid, False otherwise.
 */
function validate_password($password) {
    // At least 8 characters, 1 uppercase, 1 lowercase, 1 number
    return strlen($password) >= 8 && 
           preg_match('/[A-Z]/', $password) && 
           preg_match('/[a-z]/', $password) && 
           preg_match('/[0-9]/', $password);
}

/**
 * Validates note title.
 * @param string $title The title to validate.
 * @return bool True if valid, False otherwise.
 */
function validate_note_title($title) {
    return strlen($title) >= 1 && strlen($title) <= 255;
}

/**
 * Validates note content.
 * @param string $content The content to validate.
 * @return bool True if valid, False otherwise.
 */
function validate_note_content($content) {
    return strlen($content) >= 1;
}

/**
 * Generates a CSRF token.
 * @return string The generated token.
 */
function generate_csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Validates CSRF token.
 * @param string $token The token to validate.
 * @return bool True if valid, False otherwise.
 */
function validate_csrf_token($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Redirects to a given URL.
 * @param string $url The URL to redirect to.
 */
function redirect($url) {
    header("Location: " . $url);
    exit;
}

/**
 * Checks if a request method is POST.
 * @return bool True if POST, False otherwise.
 */
function is_post_request() {
    return $_SERVER["REQUEST_METHOD"] === "POST";
}

/**
 * Checks if a request method is GET.
 * @return bool True if GET, False otherwise.
 */
function is_get_request() {
    return $_SERVER["REQUEST_METHOD"] === "GET";
}

// Add other general utility functions here as needed.
// For example, functions for date formatting, string manipulation, etc.

?>
