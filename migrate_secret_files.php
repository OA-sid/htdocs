<?php
include 'db.php';

// Get all users
$query = "SELECT id, username, role FROM users";
$result = $conn->query($query);

$count = 0;
while ($user = $result->fetch_assoc()) {
    $userId = $user['id'];
    $username = $user['username'];
    $role = $user['role'];
    
    // Create new HTML secret file
    $newFilePath = __DIR__ . "/secret_$userId.html";
    $fileContent = "<!DOCTYPE html>
<html>
<head>
    <title>Secret File - $username</title>
    <link rel='stylesheet' href='styles.css'>
</head>
<body>
    <div class='container'>
        <div class='user-info'>
            <h1>Secret File</h1>
            <p>This is your private information page.</p>
        </div>
        
        <div class='content-box'>
            <h2>User Details</h2>
            <ul class='info-list'>
                <li><strong>Username:</strong> $username</li>
                <li><strong>Role:</strong> <span class='role-badge'>$role</span></li>
                <li><strong>User ID:</strong> $userId</li>
            </ul>
        </div>

        <div class='content-box'>
            <h2>Private Notes</h2>
            <div class='notes-area'>
                <div class='note'>
                    <h3>Welcome Note</h3>
                    <p>Welcome to your personal secret file! This space is designed to keep your private information secure and organized.</p>
                </div>
                <div class='note'>
                    <h3>Security Reminder</h3>
                    <p>Remember to keep your login credentials safe and never share them with anyone.</p>
                </div>
                <div class='note'>
                    <h3>Getting Started</h3>
                    <p>Feel free to customize this space with your own private notes and information. Your data is kept secure and private.</p>
                </div>
            </div>
        </div>

        <div class='nav-links'>
            <a href='user.php?id=$userId'>Back to Profile</a>
        </div>
    </div>
</body>
</html>";
    
    // Write new file
    file_put_contents($newFilePath, $fileContent);
    
    // Try to remove old file if it exists
    $oldFilePath = __DIR__ . "/$userId.txt";
    if (file_exists($oldFilePath)) {
        unlink($oldFilePath);
    }
    
    $count++;
}

echo "Migration complete! Updated $count secret files.";
?>
