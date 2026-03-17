<?php
// disconnect-room.php
// Immediately destroys the room when a user disconnects

session_start();

header('Content-Type: application/json');

// Get roomcode from POST or session
$roomCode = $_POST['roomcode'] ?? $_SESSION['roomcode'] ?? '';

if (!empty($roomCode)) {
    $roomCode = strtoupper(trim($roomCode));
    $filePath = __DIR__ . '/rooms/' . $roomCode . '.json';
    
    // Immediately delete the room file
    if (file_exists($filePath)) {
        unlink($filePath);
    }
}

// Clear the PHP session
$_SESSION = [];
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
session_destroy();

echo json_encode(['status' => 'success', 'message' => 'Room destroyed']);
?>
