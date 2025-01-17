<?php
if (isset($_GET['file'])) {
    $file = $_GET['file'];
    $filePath = __DIR__ . "/" . basename($file);

    if (file_exists($filePath)) {
        header('Content-Type: text/plain');
        readfile($filePath);
    } else {
        echo "File not found.";
    }
} else {
    echo "No file specified.";
}
?>