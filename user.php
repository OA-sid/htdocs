<?php
include 'db.php';

// Get user ID from URL parameter or cookie
$userId = isset($_GET['id']) ? $_GET['id'] : ($_COOKIE['user_id'] ?? null);
$token = $_COOKIE['session_token'] ?? null;

if (!$userId) {
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
    if($token) {
        echo "<p><strong>Session Token:</strong> " . htmlspecialchars($token) . "</p>";
    }

    echo "<a href='username.html'>View Username Page</a>";
    echo "<br><a href='$userId.txt'>Secret File</a>";

    // Vulnerable admin panel access
    echo "<br><a href='adminpanel.php'>Access Admin Panel</a>";
} else {
    echo "User not found.";
}
?>
