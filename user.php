<?php
include 'db.php';

// Get user ID from URL parameter or cookie
$userId = isset($_GET['id']) ? $_GET['id'] : ($_COOKIE['user_id'] ?? null);

if (!$userId) {
    die("Unauthorized access.");
}

$query = "SELECT username, role FROM users WHERE id=$userId";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $username = $row['username'];
    $role = $row['role'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>User Profile</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="user-info">
            <h1>Welcome, <?php echo htmlspecialchars($username); ?></h1>
            <p>Your role: <span class="role-badge"><?php echo htmlspecialchars($role); ?></span></p>
        </div>

        <div class="content-box">
            <h2>Quick Actions</h2>
            <div class="nav-links">
                <a href="username.html">View Username</a>
                <a href="secret.php?id=<?php echo $userId; ?>">View Secret File</a>
                <a href="adminpanel.php?id=<?php echo $userId; ?>">Access Admin Panel</a>
                <a href="vulnerable_UserAdminAccess.php?set_token=user-1234">BAC Vulnerable Admin (user token)</a>
                <a href="vulnerable_SecretArea.php?id=<?php echo $userId; ?>">Vulnerable Secret Area</a>
                <a href="encoded_user.php?profile=<?php echo base64_encode($username); ?>">Encoded User Profile</a>
                <a href="jsonbypass.txt" class="json-bypass">JSON Bypass</a>
                <a href="login.php">Logout</a>
            </div>
        </div>
    </div>
</body>
</html>
<?php
} else {
    echo '<div class="container"><div class="error">User not found.</div></div>';
}

$conn->close();
?>
