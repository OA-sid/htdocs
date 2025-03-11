<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $role = $_POST['role'] ?? 'user';
    
    // Basic validation
    if ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        // Check if username exists
        $check_query = "SELECT id FROM users WHERE username='$username'";
        $check_result = $conn->query($check_query);
        
        if ($check_result->num_rows > 0) {
            $error = "Username already exists.";
        } else {
            // Insert new user
            $query = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";
            if ($conn->query($query)) {
                // Get the new user's ID
                $userId = $conn->insert_id;
                
                // Create secret file for the user with HTML formatting
                $filePath = __DIR__ . "/secret_$userId.html";
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
                file_put_contents($filePath, $fileContent);
                
                $success = "Registration successful! You can now login.";
            } else {
                $error = "Registration failed: " . $conn->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-box">
            <div class="auth-header">
                <h2>Create Account</h2>
                <p>Sign up for a new account</p>
            </div>
            
            <?php if (isset($error)): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <?php if (isset($success)): ?>
                <div class="success"><?php echo $success; ?></div>
            <?php endif; ?>

            <form method="POST" class="auth-form">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>

                <div class="form-group">
                    <label for="role">Role</label>
                    <select id="role" name="role" class="form-select">
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>

                <button type="submit" class="btn-primary">Create Account</button>
            </form>

            <div class="auth-footer">
                <p>Already have an account? <a href="login.php">Login here</a></p>
            </div>
        </div>
    </div>
</body>
</html>
