<?php
session_start();

// Allow setting token via URL parameter for easier testing
if (isset($_GET['set_token'])) {
    $token_value = $_GET['set_token'];
    setcookie('session_token', $token_value, time() + 3600, '/');
    echo "<div style='background-color: #dff0d8; padding: 10px; border: 1px solid #3c763d; margin-bottom: 15px;'>";
    echo "Cookie 'session_token' has been set to: " . htmlspecialchars($token_value);
    echo "<br>The page will now reload with your token...";
    echo "</div>";
    echo "<script>setTimeout(function() { window.location.href = 'vulnerable_UserAdminAccess.php'; }, 2000);</script>";
    exit;
}

// Check for token in cookie
if (!isset($_COOKIE['session_token'])) {
    echo "<h1>Unauthorized access. No session token.</h1>";
    echo "<p>To test this page, you need to set a session token cookie.</p>";
    echo "<p>You can do this by clicking one of these links:</p>";
    echo "<ul>";
    echo "<li><a href='?set_token=admin-1234'>Set admin token (admin-1234)</a></li>";
    echo "<li><a href='?set_token=user-1234'>Set user token (user-1234)</a></li>";
    echo "</ul>";
    echo "<p>Or manually set a cookie named 'session_token' with value 'admin-1234' or 'user-1234'.</p>";
    exit;
}

$token = $_COOKIE['session_token'];

// Vulnerable access control - only checks if token starts with any recognized prefix
// This is vulnerable because it allows user tokens to access admin functionality
if (strpos($token, "admin-") === 0 || strpos($token, "user-") === 0) {
    // Log the access attempt but still allow it (demonstrating the vulnerability)
    $access_type = (strpos($token, "admin-") === 0) ? "legitimate admin" : "user with broken access control";
    $log_message = date('Y-m-d H:i:s') . " - Access to admin page with $access_type token: $token\n";
    // file_put_contents("access_log.txt", $log_message, FILE_APPEND);
    
    echo "<h1>Restricted Admin Functions</h1>";
    echo "<p>You have accessed the admin area with token: " . htmlspecialchars($token) . "</p>";
    
    if (strpos($token, "user-") === 0) {
        echo "<div style='background-color: #ffdddd; padding: 10px; border: 1px solid #ff0000;'>";
        echo "<strong>WARNING:</strong> You have accessed this page with a user token. ";
        echo "This represents a Broken Access Control vulnerability!";
        echo "</div>";
    }
    
    // Display admin functionality
    echo "<div class='admin-panel' style='margin-top: 20px;'>";
    
    // User Management Section
    echo "<div class='section' style='margin: 20px 0; padding: 15px; border: 1px solid #ccc;'>";
    echo "<h3>System Management</h3>";
    echo "<ul>";
    echo "<li><a href='#'>Reset All User Passwords</a></li>";
    echo "<li><a href='#'>Delete User Accounts</a></li>";
    echo "<li><a href='#'>Export User Data</a></li>";
    echo "<li><a href='#'>View System Logs</a></li>";
    echo "</ul>";
    echo "</div>";
    
    // Configuration Section
    echo "<div class='section' style='margin: 20px 0; padding: 15px; border: 1px solid #ccc;'>";
    echo "<h3>Configuration Settings</h3>";
    echo "<form method='POST' action=''>";
    echo "<label>Site Maintenance Mode: <input type='checkbox' name='maintenance'></label><br>";
    echo "<label>Debug Mode: <input type='checkbox' name='debug'></label><br>";
    echo "<label>Max Upload Size (MB): <input type='text' name='max_upload' value='10'></label><br>";
    echo "<label>Session Timeout (minutes): <input type='text' name='timeout' value='30'></label><br>";
    echo "<input type='submit' value='Save Settings'>";
    echo "</form>";
    echo "</div>";
    
    // Sensitive Data Section
    echo "<div class='section' style='margin: 20px 0; padding: 15px; border: 1px solid #ccc;'>";
    echo "<h3>Sensitive Data Access</h3>";
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr><th>Database</th><th>Username</th><th>Password</th><th>Server</th></tr>";
    echo "<tr><td>Production</td><td>admin_prod</td><td>Pr0d@ccess2023!</td><td>db.production.local</td></tr>";
    echo "<tr><td>Development</td><td>dev_user</td><td>Dev$ecret123</td><td>db.development.local</td></tr>";
    echo "<tr><td>Testing</td><td>test_user</td><td>T3st!ng456</td><td>db.testing.local</td></tr>";
    echo "</table>";
    echo "</div>";
    
    // Add a link to clear the cookie for easier testing
    echo "<div style='margin-top: 20px;'>";
    echo "<a href='?set_token=clear' style='color: #666;'>Clear token and logout</a>";
    echo "</div>";
    
    echo "</div>";
    
} else {
    die("Access Denied: Invalid token format.");
}
?> 