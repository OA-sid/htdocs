<?php
if (isset($_GET['profile'])) {
    $encodedProfile = $_GET['profile'];
    $decodedProfile = base64_decode($encodedProfile);
    echo "<h1>Decoded Profile: " . htmlspecialchars($decodedProfile) . "</h1>";
} else {
    echo "No profile parameter provided.";
}
?>
