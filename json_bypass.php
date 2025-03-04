<?php
// Check if the requested file ends with .json
$requestedFile = $_GET['file'] ?? '';
$originalFile = str_replace('.json', '', $requestedFile);

// If someone tries to access the file directly without .json
if ($requestedFile === $originalFile) {
    header("HTTP/1.0 403 Forbidden");
    exit("Access Denied");
}

// If file exists and ends with .json, serve it
if (file_exists($originalFile)) {
    header('Content-Type: application/json');
    $content = file_get_contents($originalFile);
    echo json_encode(['content' => $content]);
} else {
    header("HTTP/1.0 404 Not Found");
    echo json_encode(['error' => 'File not found']);
}
