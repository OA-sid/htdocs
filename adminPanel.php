<?php
// Get session token
$token = $_COOKIE['session_token'] ?? null;

if (!$token) {
    die("Unauthorized access.");
}

// **Vulnerability**: Any logged-in user can access this panel
echo "<h1>Welcome to the Admin Panel</h1>";
echo "<p>This page should be accessible only by admins, but it's vulnerable and accessible to normal users as well.</p>";
?>
