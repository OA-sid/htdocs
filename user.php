<?php
include 'db.php';

$userId = $_GET['id'] ?? null;
$query = "SELECT username, is_admin FROM users WHERE id=$userId";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $username = $row['username'];
    $isAdmin = $row['is_admin'];

    echo "<h1>Welcome, " . htmlspecialchars($username) . "</h1>";
    echo "<p>Your session token: " . ($_COOKIE['session_token'] ?? 'None') . "</p>";

    // Link to intentionally vulnerable admin panel
    echo "<br><a href='adminpanel.php'>Go to Admin Panel</a>";
} else {
    echo "User not found.";
}
?>
