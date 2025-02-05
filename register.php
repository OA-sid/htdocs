<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? null;
    $password = $_POST['password'] ?? null;
    $role = $_POST['role'] ?? 'user';

    if (!$username || !$password) {
        die("Please provide both username and password.");
    }

    // Insert into database
    $query = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";
    if ($conn->query($query) === TRUE) {
        $userId = $conn->insert_id;

        // Create a text file with user details
        $filePath = __DIR__ . "/$userId.txt";
        $fileContent = "Username: $username\nPassword: $password\nRole: $role";
        file_put_contents($filePath, $fileContent);

        echo "User registered successfully as $role! Your ID is $userId.";
        echo "<br><a href='index.html'>Go to Login</a>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
