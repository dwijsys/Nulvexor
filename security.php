<?php
// Centralized security helpers

function is_local_host(): bool
{
    $host = $_SERVER['HTTP_HOST'] ?? '';
    if ($host === '127.0.0.1' || $host === 'localhost') return true;
    // Allow common local dev domains (Laragon uses *.test by default)
    if (str_ends_with($host, '.test') || str_ends_with($host, '.local')) return true;
    // RFC1918 blocks for LAN dev
    if (preg_match('/^(10\.|192\.168\.|172\.(1[6-9]|2[0-9]|3[0-1])\.)/', $host)) return true;
    return false;
}

function start_secure_session(): void
{
    $params   = session_get_cookie_params();
    $protoHdr = $_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '';
    $isHttps  = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || ($protoHdr === 'https');
    $isLocal  = is_local_host();

    // Use Secure cookies only when HTTPS is actually in use. This keeps local HTTP (Laragon) working.
    $secureCookies = $isHttps;

    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => $params['path'],
        'domain'   => $params['domain'],
        'secure'   => $secureCookies,
        'httponly' => true,
        'samesite' => 'Strict',
    ]);

    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    if (!isset($_SESSION['__regenerated'])) {
        session_regenerate_id(true);
        $_SESSION['__regenerated'] = time();
    }
}

function send_security_headers(): void
{
    $isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https');

    header('X-Frame-Options: DENY');
    header('X-Content-Type-Options: nosniff');
    header('Referrer-Policy: same-origin');
    header('Permissions-Policy: camera=(), microphone=(), geolocation=()');

    if ($isHttps) {
        header('Strict-Transport-Security: max-age=31536000; includeSubDomains; preload');
    }

    $csp = "default-src 'self'; "
         . "img-src 'self' data:; "
         . "connect-src 'self'; "
         . "font-src 'self' https://fonts.gstatic.com; "
         . "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; "
         . "script-src 'self' 'unsafe-inline' https://cdn.tailwindcss.com; "
         . "object-src 'none'; "
         . "frame-ancestors 'none'";

    header('Content-Security-Policy: ' . $csp);
}

function get_csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function require_csrf_token(): void
{
    $token = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? ($_POST['csrf_token'] ?? '');
    $known = $_SESSION['csrf_token'] ?? '';

    if (!$token || !$known || !hash_equals($known, $token)) {
        http_response_code(403);
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => 'CSRF validation failed']);
        exit;
    }
}

function require_post_method(): void
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        exit;
    }
}

function sanitize_alias(string $value): string
{
    return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
}

function sanitize_room_code(string $value): string
{
    return preg_replace('/[^A-Z0-9]/', '', strtoupper($value));
}
?>
