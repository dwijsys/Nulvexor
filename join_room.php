<?php
// join_room.php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $roomCode = strtoupper(trim($_POST['roomcode'] ?? ''));

    if (empty($username) || empty($roomCode)) {
        header('Location: ./?error=MissingFields');
        exit;
    }

    // Check if room exists
    $filePath = __DIR__ . '/rooms/' . $roomCode . '.json';
    if (!file_exists($filePath)) {
        header('Location: ./?error=RoomNotFound');
        exit;
    }

    // Store in session
    $_SESSION['username'] = htmlspecialchars($username, ENT_QUOTES, 'UTF-8');
    $_SESSION['roomcode'] = $roomCode;
    
    header('Location: room');
    exit;
} else {
    header('Location: ./');
    exit;
}
?>
