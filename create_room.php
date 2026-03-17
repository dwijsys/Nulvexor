<?php
// create_room.php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');

    if (empty($username)) {
        header('Location: ./?error=UsernameRequired');
        exit;
    }

    // Generate random 6 character code and ensure uniqueness
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $roomsDir = __DIR__ . '/rooms';
    if (!is_dir($roomsDir)) {
        mkdir($roomsDir, 0777, true);
    }

    do {
        $roomCode = '';
        for ($i = 0; $i < 6; $i++) {
            $roomCode .= $characters[rand(0, strlen($characters) - 1)];
        }
        $filePath = $roomsDir . '/' . $roomCode . '.json';
    } while (file_exists($filePath));

    // Store in session
    $_SESSION['username'] = htmlspecialchars($username, ENT_QUOTES, 'UTF-8');
    $_SESSION['roomcode'] = $roomCode;

    $roomData = [
        'roomcode' => $roomCode,
        'created' => time(),
        'participants' => [],
        'messages' => []
    ];
    
    file_put_contents($filePath, json_encode($roomData, JSON_PRETTY_PRINT));

    header('Location: room');
    exit;
} else {
    header('Location: ./');
    exit;
}
?>
