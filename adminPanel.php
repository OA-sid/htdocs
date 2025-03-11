<?php
// Get session token
$token = $_COOKIE['session_token'] ?? null;

if (!$token) {
    die("Unauthorized access.");
}

// Connect to the database
require_once 'config.php';
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Verify if the user has admin privileges
$stmt = $conn->prepare("SELECT role FROM users WHERE session_token = ?");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user || $user['role'] !== 'admin') {
    header("HTTP/1.1 403 Forbidden");
    die("Access denied. This page is only accessible to administrators.");
}

// If we reach here, the user is an admin
echo "<h1>Welcome to the Admin Panel</h1>";
echo "<p>Welcome administrator! You have full access to manage the system.</p>";

$stmt->close();
$conn->close();
?>
