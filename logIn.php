<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Query the database
    $query = "SELECT id, role FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $userId = $row['id'];
        $role = $row['role'];

        // Assign token based on role
        $token = ($role === 'admin') ? 'admin-1234' : 'user-1234';

        // Store token in cookies
        setcookie("session_token", $token, time() + 3600, "/");
        setcookie("user_id", $userId, time() + 3600, "/");

        header("Location: user.php?id=$userId");
        exit;
    } else {
        echo "Invalid username or password.";
    }
}
?>
