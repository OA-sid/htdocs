<?php
include 'db.php';

// Get user ID from URL parameter
$userId = $_GET['id'] ?? null;

if (!$userId) {
    die('<div class="container"><div class="error">Access denied - No user ID provided</div></div>');
}

// Get user details
$query = "SELECT username, role FROM users WHERE id = $userId";
$result = $conn->query($query);

if (!$result || $result->num_rows === 0) {
    die('<div class="container"><div class="error">User not found</div></div>');
}

$user = $result->fetch_assoc();
$username = $user['username'];
$role = $user['role'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Secret File - <?php echo htmlspecialchars($username); ?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="user-info">
            <h1>Secret File</h1>
            <p>This is your private information page.</p>
        </div>
        
        <div class="content-box">
            <h2>User Details</h2>
            <ul class="info-list">
                <li><strong>Username:</strong> <?php echo htmlspecialchars($username); ?></li>
                <li><strong>Role:</strong> <span class="role-badge"><?php echo htmlspecialchars($role); ?></span></li>
                <li><strong>User ID:</strong> <?php echo htmlspecialchars($userId); ?></li>
            </ul>
        </div>

        <div class="nav-links">
            <a href="user.php?id=<?php echo htmlspecialchars($userId); ?>">Back to Profile</a>
        </div>
    </div>
</body>
</html>
