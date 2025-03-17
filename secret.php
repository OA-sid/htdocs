<?php
include 'db.php';

// Get user ID from URL parameter
$userId = $_GET['id'] ?? null;

// VULNERABLE: No validation on the user ID parameter
// This allows for path traversal attacks like id=../config or id=1/../2

if (!$userId) {
    die('Access denied - No user ID provided');
}

// Get user details
$query = "SELECT username, role FROM users WHERE id = $userId";
$result = $conn->query($query);

if (!$result || $result->num_rows === 0) {
    die('User not found');
}

$user = $result->fetch_assoc();
$username = $user['username'];

// First check if there's a file in the secrets directory
$secretFilePath = "secrets/{$userId}.txt";

// If not found in secrets directory, check the root directory
if (!file_exists($secretFilePath)) {
    $secretFilePath = "{$userId}.txt";
}

// Check if the secret file exists in either location
if (file_exists($secretFilePath)) {
    // Set content type to plain text
    header('Content-Type: text/plain');
    
    // Output the file content
    readfile($secretFilePath);
} else {
    // If file doesn't exist, show an error
    echo "Secret file for user {$username} (ID: {$userId}) not found.";
    echo "\n\nPlease contact the administrator if you believe this is an error.";
}
?>
