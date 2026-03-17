<?php
// destroy_room.php
// Called when user disconnects / closes tab
// Clears the PHP session and optionally cleans up empty room files

session_start();

header('Content-Type: application/json');

// Optional: Clean up room file if user was the last one
// (This is optional - files will auto-delete when all messages burn)
if (isset($_SESSION['roomcode'])) {
    $roomCode = $_SESSION['roomcode'];
    $filePath = __DIR__ . '/rooms/' . $roomCode . '.json';
    
    // Only delete if file exists and has no messages
    if (file_exists($filePath)) {
        $json = file_get_contents($filePath);
        $roomData = json_decode($json, true);
        
        if (empty($roomData['messages'])) {
            unlink($filePath);
        }
    }
}

// Destroy session completely
$_SESSION = [];
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
session_destroy();

echo json_encode(['status' => 'destroyed']);
?>
