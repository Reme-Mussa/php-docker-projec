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
