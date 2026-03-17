<?php
// send_message.php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['username']) || !isset($_SESSION['roomcode'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    if (!$data) {
        $data = $_POST;
    }

    $message  = trim($data['message']  ?? '');
    $burnTime = intval($data['burnTime'] ?? 0);
    $senderId = trim($data['senderId']  ?? '');
    $username = $_SESSION['username'];

    // ROOM ISOLATION: always use room code from session, never from client
    $roomCode = $_SESSION['roomcode'];

    if (empty($message) || empty($senderId)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
        exit;
    }

    $newMessage = [
        'id'       => uniqid('msg_'),
        'senderId' => $senderId,
        'user'     => $username,
        'cipher'   => $message,    // AES-256-GCM E2EE payload (client-side encrypted)
        'burnTime' => $burnTime,
        'time'     => time(),
    ];

    // Store in file
    $filePath = __DIR__ . '/rooms/' . $roomCode . '.json';

    if (!file_exists($filePath)) {
        echo json_encode(['status' => 'error', 'message' => 'Room connection lost — please refresh']);
        exit;
    }

    $json = file_get_contents($filePath);
    $roomData = json_decode($json, true);

    if (!$roomData || !is_array($roomData)) {
        echo json_encode(['status' => 'error', 'message' => 'Room data corrupted — please clear room']);
        exit;
    }

    if (!isset($roomData['messages'])) {
        $roomData['messages'] = [];
    }

    $roomData['messages'][] = $newMessage;
    if (file_put_contents($filePath, json_encode($roomData, JSON_PRETTY_PRINT))) {
        echo json_encode(['status' => 'success', 'id' => $newMessage['id']]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Server failed to save message']);
    }
    exit;
}
?>
