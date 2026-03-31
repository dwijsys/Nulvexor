<?php
// join_room.php
require_once __DIR__ . '/security.php';
start_secure_session();
send_security_headers();
require_post_method();
require_csrf_token();

$now = time();
if (isset($_SESSION['last_room_action']) && ($now - $_SESSION['last_room_action']) < 2) {
    header('Location: ./?error=RateLimited');
    exit;
}
$_SESSION['last_room_action'] = $now;

$username = sanitize_alias($_POST['username'] ?? '');
$roomCode = sanitize_room_code($_POST['roomcode'] ?? '');

if ($username === '' || $roomCode === '') {
    header('Location: ./?error=MissingFields');
    exit;
}

if (strlen($username) > 64) {
    $username = substr($username, 0, 64);
}

// Accept legacy 6-char and new 12-char codes
if (strlen($roomCode) < 6 || strlen($roomCode) > 16) {
    header('Location: ./?error=RoomNotFound');
    exit;
}

// Check if room exists
$filePath = __DIR__ . '/rooms/' . $roomCode . '.json';
if (!file_exists($filePath)) {
    header('Location: ./?error=RoomNotFound');
    exit;
}

// Store in session
$_SESSION['username'] = $username;
$_SESSION['roomcode'] = $roomCode;
    
header('Location: room');
exit;
?>
