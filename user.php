<?php
include 'db.php';

$userId = $_GET['id'];
$query = "SELECT username FROM users WHERE id=$userId";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo "<h1>Welcome, " . htmlspecialchars($row['username']) . "</h1>";
    echo "<a href='username.html'>View Username Page</a>";
    echo "<br><a href='$userId.txt'>Secret File</a>"; // Link to user-specific text file

    // Generate Base64 encoded link
    $base64Profile = base64_encode($row['username']);
    echo "<br><a href='encoded_user.php?profile=$base64Profile'>View Encoded Profile</a>";
} else {
    echo "User not found.";
}
?>
