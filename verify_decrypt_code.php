<?php
// verify_decrypt_code.php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['username']) || !isset($_SESSION['roomcode'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    $messageId = trim($data['messageId'] ?? '');
    $decryptCode = trim($data['decryptCode'] ?? '');
    $roomCode = $_SESSION['roomcode'] ?? '';
    
    if (empty($messageId) || empty($decryptCode) || empty($roomCode)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
        exit;
    }
    
    $filePath = __DIR__ . '/rooms/' . $roomCode . '.json';
    
    if (!file_exists($filePath)) {
        echo json_encode(['status' => 'error', 'message' => 'Room not found']);
        exit;
    }
    
    $json = file_get_contents($filePath);
    $roomData = json_decode($json, true);
    
    // Find the message
    $message = null;
    foreach ($roomData['messages'] as $msg) {
        if ($msg['id'] === $messageId) {
            $message = $msg;
            break;
        }
    }
    
    if (!$message) {
        echo json_encode(['status' => 'error', 'message' => 'Message not found']);
        exit;
    }
    
    // Verify decrypt code
    if (empty($message['decryptCodeHash'])) {
        echo json_encode(['status' => 'error', 'message' => 'No decrypt code set']);
        exit;
    }
    
    if (password_verify($decryptCode, $message['decryptCodeHash'])) {
        echo json_encode(['status' => 'success', 'valid' => true]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid decrypt code', 'valid' => false]);
    }
    exit;
}
?>
