<?php
session_start();

// Basic authentication check (vulnerable)
$allowed_users = array("test_user", "admin_user");
$current_user = isset($_GET['user']) ? $_GET['user'] : '';

if (!in_array($current_user, $allowed_users)) {
    // First layer of "security"
    if (isset($_SERVER['HTTP_X_CLIENT_IP']) && $_SERVER['HTTP_X_CLIENT_IP'] === "127.0.0.1") {
        echo "<h1>Welcome to Secret Area</h1>";
        echo "<p>Access granted via X-Client-IP bypass!</p>";
        echo "<p>Confidential Information:</p>";
        echo "<ul>";
        echo "<li>Secret Key: ABC123XYZ</li>";
        echo "<li>Internal API Endpoint: api.internal.example.com</li>";
        echo "<li>Database Connection: db.local:3306</li>";
        echo "</ul>";
    } else {
        die("Access Denied.");
    }
} else {
    echo "<h1>Welcome Authorized User</h1>";
    echo "<p>You have accessed the secret area through normal means.</p>";
}
?> 