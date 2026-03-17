<?php
// fetch_messages.php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['username']) || !isset($_SESSION['roomcode'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit;
}

$roomCode = $_SESSION['roomcode'];
$filePath = __DIR__ . '/rooms/' . $roomCode . '.json';

if (!file_exists($filePath)) {
    echo json_encode(['status' => 'error', 'message' => 'Room expired', 'code' => 'ROOM_BURNED']);
    exit;
}

$json = file_get_contents($filePath);
$roomData = json_decode($json, true);

$currentTime = time();
$createdTime = intval($roomData['created'] ?? 0);

// Room expiration: 24 hours (86400 seconds)
if ($createdTime > 0 && ($currentTime - $createdTime) > 86400) {
    if (file_exists($filePath)) unlink($filePath);
    echo json_encode(['status' => 'error', 'message' => 'Room expired']);
    exit;
}

// Heartbeat System
$senderId = $_GET['senderId'] ?? '';
if (!isset($roomData['participants'])) {
    $roomData['participants'] = [];
}

if (!empty($senderId)) {
    $roomData['participants'][$senderId] = $currentTime;
}

// Clean up inactive participants (timeout: 15 seconds for safety)
$activeParticipants = [];
foreach ($roomData['participants'] as $uid => $lastSeen) {
    if (($currentTime - $lastSeen) < 15) {
        $activeParticipants[$uid] = $lastSeen;
    }
}
$roomData['participants'] = $activeParticipants;

// PERSIST HEARTBEAT: Save the updated participants list back to the file
file_put_contents($filePath, json_encode($roomData, JSON_PRETTY_PRINT));

// Auto-delete room if no heartbeats in the last 15 seconds
if (empty($roomData['participants'])) {
    if (file_exists($filePath)) unlink($filePath);
    echo json_encode(['status' => 'error', 'message' => 'Room closed (no users)']);
    exit;
}

$messages = $roomData['messages'] ?? [];
$activeMessages = [];

// Filter out burned messages
foreach ($messages as $msg) {
    $burnTime = intval($msg['burnTime'] ?? 0);
    $messageTime = intval($msg['time'] ?? 0);
    
    if ($burnTime > 0 && ($currentTime - $messageTime) >= $burnTime) {
        // Message has burned, skip it
        continue;
    }
    
    $activeMessages[] = $msg;
}

// Update file if messages were burned
if (count($activeMessages) !== count($messages)) {
    $roomData['messages'] = $activeMessages;
    file_put_contents($filePath, json_encode($roomData, JSON_PRETTY_PRINT));
}

echo json_encode([
    'status'       => 'success',
    'messages'     => $activeMessages,
    'current_time' => $currentTime,
    'roomcode'     => $roomCode   // JS uses this to detect session drift
]);
?>
