<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $query = "SELECT id, is_admin FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $userId = $row['id'];
        $isAdmin = $row['is_admin'];

        // Assign session token
        if ($isAdmin) {
            $token = "admin-1234";
        } else {
            $token = "user-1234";
        }

        // Store token in cookies
        setcookie("session_token", $token, time() + 3600, "/"); 

        header("Location: user.php?id=$userId");
        exit;
    } else {
        echo "Invalid username or password.";
    }
}
?>
