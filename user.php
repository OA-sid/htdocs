<?php
include 'db.php';

// Fetch session token and user ID from cookies
$token = $_COOKIE['session_token'] ?? null;
$userId = $_COOKIE['user_id'] ?? null;

if (!$userId || !$token) {
    die("Unauthorized access.");
}

$query = "SELECT username, role FROM users WHERE id=$userId";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $username = $row['username'];
    $role = $row['role'];

    echo "<h1>Welcome, " . htmlspecialchars($username) . "</h1>";
    echo "<p>Your role: " . htmlspecialchars($role) . "</p>";
    echo "<p><strong>Session Token:</strong> " . htmlspecialchars($token) . "</p>"; // Display session token

    echo "<a href='username.html'>View Username Page</a>";
    echo "<br><a href='$userId.txt'>Secret File</a>";

    // Vulnerable admin panel access
    echo "<br><a href='adminpanel.php'>Access Admin Panel</a>";
} else {
    echo "User not found.";
}
?>
