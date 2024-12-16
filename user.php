<?php
include 'db.php';

$userId = $_GET['id'];
$query = "SELECT username FROM users WHERE id=$userId";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo "<h1>Welcome, " . htmlspecialchars($row['username']) . "</h1>";
    echo "<a href='username.html'>View Username Page</a>";
} else {
    echo "User not found.";
}
?>