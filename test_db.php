<?php
$conn = new mysqli("localhost", "root", "", "vulnerability_tool");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Database connected successfully!";
}
?>
