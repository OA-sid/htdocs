<?php
include 'db.php';

// Get user ID from URL parameter or cookie
$userId = isset($_GET['id']) ? $_GET['id'] : ($_COOKIE['user_id'] ?? null);

if (!$userId) {
    die('<div class="container"><div class="error">Access denied - No user ID</div></div>');
}

// Check if user is admin
$query = "SELECT username, role FROM users WHERE id = $userId";
$result = $conn->query($query);

if (!$result) {
    die('<div class="container"><div class="error">Database error: ' . $conn->error . '</div></div>');
}

$user = $result->fetch_assoc();

// Get all users if admin
$allUsers = [];
if ($user && $user['role'] === 'admin') {
    $users_query = "SELECT id, username, role FROM users ORDER BY id";
    $users_result = $conn->query($users_query);
    while ($row = $users_result->fetch_assoc()) {
        $allUsers[] = $row;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <?php if (!$user || $user['role'] !== 'admin'): ?>
            <div class="error">Access denied</div>
        <?php else: ?>
            <div class="success">Access granted</div>
            <div class="user-info">
                <h1>Welcome <?php echo htmlspecialchars($user['username']); ?>!</h1>
                <p>You have admin privileges.</p>
            </div>

            

            <div class="nav-links">
                <a href="user.php?id=<?php echo $userId; ?>">Back to Profile</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
<?php
$conn->close();
?>