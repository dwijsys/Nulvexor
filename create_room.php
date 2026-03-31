<?php
// create_room.php
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

if ($username === '') {
    header('Location: ./?error=UsernameRequired');
    exit;
}

if (strlen($username) > 64) {
    $username = substr($username, 0, 64);
}

// Generate random 12 character code and ensure uniqueness
$roomsDir = __DIR__ . '/rooms';
if (!is_dir($roomsDir)) {
    mkdir($roomsDir, 0777, true);
}

$alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
$codeLength = 12;
do {
    $bytes = random_bytes($codeLength);
    $roomCode = '';
    for ($i = 0; $i < $codeLength; $i++) {
        $roomCode .= $alphabet[ord($bytes[$i]) % strlen($alphabet)];
    }
    $filePath = $roomsDir . '/' . $roomCode . '.json';
} while (file_exists($filePath));

// Store in session
$_SESSION['username'] = $username;
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
?>
