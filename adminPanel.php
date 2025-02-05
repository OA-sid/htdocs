<?php
include 'db.php';

// Check session token
$token = $_COOKIE['session_token'] ?? '';

if ($token == "admin-1234" || $token == "user-1234") {  // Vulnerability: Allows both user and admin access
    echo "<h1>Welcome to Admin Panel</h1>";
    echo "<p>This is an intentionally vulnerable admin panel accessible by normal users too.</p>";
} else {
    echo "Access denied!";
}
?>
