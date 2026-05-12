<?php
// index.php
require_once __DIR__ . '/security.php';
start_secure_session();
send_security_headers();

$roomFromLink = isset($_GET['room']) ? htmlspecialchars($_GET['room']) : null;
$csrfToken = get_csrf_token();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>Nulvexor — Cryptographic Communication Platform</title>
    <link rel="icon" type="image/svg+xml" href="assets/favicon.svg?v=2">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/custom.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        dark: {
                            950: '#07070a',
                            900: '#0b0b0f',
                            800: '#111114',
                            700: '#16161a',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-[#0b0b0f] text-white min-h-screen relative overflow-x-hidden">
    <!-- Premium Ambient Glow System -->
    <div class="glow-ambient-wrapper"></div>
    
    <!-- Design Elements -->
    <div class="grid-background"></div>
    <div class="radial-glow top-0 left-1/4 -translate-x-1/2 opacity-50"></div>
    <div class="radial-glow bottom-0 right-0 opacity-30"></div>

    <!-- MOBILE-ONLY LANDING PAGE -->
    <div id="mobileLandingPage" class="md:hidden fixed inset-0 z-[9999] mobile-notice-shell" role="main" aria-labelledby="mobileNoticeTitle">
        <div class="mobile-notice-orb mobile-notice-orb--a" aria-hidden="true"></div>
        <div class="mobile-notice-orb mobile-notice-orb--b" aria-hidden="true"></div>

        <section class="mobile-notice-card">
            <header class="mobile-notice-header">
                <img src="assets/logo.svg?v=2" alt="Nulvexor" class="mobile-notice-logo">
                <div class="mobile-notice-branding">
                    <p class="mobile-notice-kicker">NULVEXOR</p>
                    <p class="mobile-notice-subkicker">Secure Communication Platform</p>
                </div>
                <span class="mobile-notice-chip">Desktop Preferred</span>
            </header>

            <h1 id="mobileNoticeTitle" class="mobile-notice-title">Mobile Uplink Restricted</h1>

            <p class="mobile-notice-text">
                To maintain strict zero-knowledge standards and ensure the integrity of our end-to-end encryption protocols, mobile access is temporarily restricted. Please establish a secure connection via a desktop environment.
            </p>

            <div class="mobile-notice-guide" aria-label="Quick guide">
                <h2 class="mobile-notice-guide-title">Quick Guide</h2>
                <div class="mobile-notice-guide-points">
                    <p class="mobile-notice-guide-point">1. Create or join a room using a secure room code.</p>
                    <p class="mobile-notice-guide-point">2. Share the encryption key privately with participants.</p>
                    <p class="mobile-notice-guide-point">3. Exchange protected messages with burn timers.</p>
                </div>
                <a href="guide" class="mobile-notice-guide-link" aria-label="Open Nulvexor guide">
                    Read Full Guide
                </a>
            </div>

            <div class="mobile-notice-links" aria-label="Social links">
                <a href="https://www.linkedin.com/in/dwij-malaviya-9014a82a6" target="_blank" rel="noopener noreferrer" class="mobile-notice-link mobile-notice-link--icon" aria-label="LinkedIn profile">
                    <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M19 0h-14C2.239 0 0 2.239 0 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5V5c0-2.761-2.238-5-5-5zM7.119 20.452H3.558V9h3.561v11.452zM5.338 7.433c-1.137 0-2.06-.945-2.06-2.112 0-1.167.923-2.112 2.06-2.112 1.138 0 2.061.945 2.061 2.112 0 1.167-.923 2.112-2.061 2.112zM20.452 20.452h-3.561v-5.576c0-1.33-.027-3.039-1.852-3.039-1.853 0-2.136 1.446-2.136 2.941v5.674H9.342V9h3.415v1.561h.048c.476-.9 1.637-1.852 3.368-1.852 3.602 0 4.279 2.371 4.279 5.455v6.288z"/>
                    </svg>
                </a>
            </div>
        </section>
    </div>

    <!-- DESKTOP CONTENT (HIDDEN ON MOBILE) -->
    <div id="desktopContent" class="hidden md:block">

    <!-- Navbar -->
    <nav class="nav-glass fixed top-0 w-full z-50 px-6 box-border">
        <div class="max-w-7xl mx-auto nav-height flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="./" class="flex items-center gap-3 group">
                    <img src="assets/logo.svg?v=2" alt="Nulvexor" class="w-10 h-10 group-hover:rotate-12 transition-transform duration-300">
                    <span class="text-xl font-bold tracking-tighter text-white">NULVEXOR</span>
                </a>
                <div class="nav-links">
                    <a href="./" class="nav-link nav-link--active">Home</a>
                    <a href="#features" class="nav-link">Protocols</a>
                    <a href="guide" class="nav-link flex items-center gap-2">
                        <span>Guide</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </a>
                </div>
                <button class="mobile-nav-toggle" id="mobileNavToggle" aria-label="Open menu">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
            </div>
            <div class="flex items-center gap-3">
                <a href="https://www.linkedin.com/in/dwij-malaviya-9014a82a6" target="_blank" class="nav-cta nav-cta--icon" aria-label="LinkedIn">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14C2.239 0 0 2.239 0 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5V5c0-2.761-2.238-5-5-5zM7.119 20.452H3.558V9h3.561v11.452zM5.338 7.433c-1.137 0-2.06-.945-2.06-2.112 0-1.167.923-2.112 2.06-2.112 1.138 0 2.061.945 2.061 2.112 0 1.167-.923 2.112-2.061 2.112zM20.452 20.452h-3.561v-5.576c0-1.33-.027-3.039-1.852-3.039-1.853 0-2.136 1.446-2.136 2.941v5.674H9.342V9h3.415v1.561h.048c.476-.9 1.637-1.852 3.368-1.852 3.602 0 4.279 2.371 4.279 5.455v6.288z"/></svg>
                </a>
            </div>
        </div>
        <div class="mobile-nav-backdrop" id="mobileNavBackdrop"></div>
        <div class="mobile-nav-drawer" id="mobileNavDrawer">
            <a href="./">Home</a>
            <a href="#features">Protocols</a>
            <a href="guide" class="flex items-center gap-2">Guide <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg></a>
            <a href="https://www.linkedin.com/in/dwij-malaviya-9014a82a6" target="_blank" class="flex items-center gap-2" aria-label="LinkedIn"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14C2.239 0 0 2.239 0 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5V5c0-2.761-2.238-5-5-5zM7.119 20.452H3.558V9h3.561v11.452zM5.338 7.433c-1.137 0-2.06-.945-2.06-2.112 0-1.167.923-2.112 2.06-2.112 1.138 0 2.061.945 2.061 2.112 0 1.167-.923 2.112-2.061 2.112zM20.452 20.452h-3.561v-5.576c0-1.33-.027-3.039-1.852-3.039-1.853 0-2.136 1.446-2.136 2.941v5.674H9.342V9h3.415v1.561h.048c.476-.9 1.637-1.852 3.368-1.852 3.602 0 4.279 2.371 4.279 5.455v6.288z"/></svg></a>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="pt-32 pb-20 px-6 relative overflow-hidden">
        <div class="max-w-7xl mx-auto flex flex-col lg:flex-row items-center gap-16">
            <div class="flex-1 text-center lg:text-left animate-fade-in-up">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 text-xs font-semibold tracking-wide mb-6">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                    </span>
                    PROTOCOL V3.5 — E2EE RATIFIED
                </div>
                <h1 class="hero-title mb-6">
                    THE ULTIMATE <br class="hidden md:block"> SECURE GRID
                </h1>
                <p class="text-lg md:text-xl text-gray-400 mb-10 max-w-2xl mx-auto lg:mx-0 leading-relaxed font-medium">
                    Zero-Knowledge E2EE, HKDF-SHA256 ratcheting, 12-char codes, CSRF-hardened forms, and CSP/HSTS by default. Keys never leave your device.
                </p>
                <div class="flex flex-wrap items-center justify-center lg:justify-start gap-4">
                    <a href="#app" class="glass-panel px-8 py-4 h-14 text-base flex items-center justify-center font-bold text-white transition-preset border border-white/5 gap-2 group">
                        <svg class="w-5 h-5 text-indigo-400 transition-colors group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                       Initialize  Connection
                    </a>
                    <a href="guide" class="glass-panel px-8 py-4 h-14 text-base flex items-center justify-center font-bold text-white transition-preset border border-white/5 gap-2 group">
                        <svg class="w-5 h-5 text-indigo-400 transition-colors group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Operational Guide
                    </a>
                </div>
            </div>

            <!-- Floating Activity Cards (Visual Only) -->
            <div class="flex-1 relative w-full max-w-lg lg:max-w-none animate-fade-in-up" style="animation-delay: 200ms;">
                <div class="relative z-10 space-y-4">
                    <div class="glass-panel p-4 flex items-center gap-4 max-w-md ml-auto translate-x-4 border-l-4 border-indigo-500 shadow-2xl shadow-indigo-500/20">
                        <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center text-white">🛡️</div>
                        <div>
                            <p class="text-sm font-bold text-white uppercase tracking-wider">
                                HKDF-SHA256 RATCHET (142)
                            </p>
                            <p class="text-xs text-white font-mono opacity-50">CHAIN INDEX — ROTATED</p>
                        </div>
                    </div>
                    <div class="glass-panel p-6 max-w-sm mx-auto shadow-2xl shadow-indigo-500/20 border-t-2 border-indigo-500/30">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-xs font-bold text-white tracking-widest uppercase">
                                AES-256-GCM (LEVEL 5)
                            </span>
                            <span class="text-xs text-white font-mono italic">VERIFIED</span>
                        </div>
                        <p class="text-sm font-mono text-gray-300 break-words opacity-70">
                            v3.5:j4k9+8Lp+2N/3mQ9vj8X/k6lP/9RrkE0U2U=
                        </p>
                    </div>
                    <div class="glass-panel p-4 flex items-center gap-4 max-w-xs mr-auto -translate-x-4 border-r-4 border-indigo-500 shadow-2xl shadow-indigo-500/20">
                        <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center text-white">🔥</div>
                        <div>
                            <p class="text-sm font-bold text-white uppercase tracking-wider">
                                EPHEMERAL BURST (ARMED)
                            </p>
                            <p class="text-xs text-white font-mono opacity-50">PURGE ARMED</p>
                        </div>
                    </div>
                </div>
                <!-- Background decorative elements -->
                <div class="absolute -top-10 -right-10 w-64 h-64 bg-indigo-500/10 rounded-full blur-3xl opacity-50"></div>
                <div class="absolute -bottom-10 -left-10 w-64 h-64 bg-indigo-500/10 rounded-full blur-3xl opacity-50"></div>
            </div>
        </div>
    </section>

    <!-- Features Grid -->
    <section id="features" class="py-24 px-6 border-y border-white/5 relative bg-dark-900/50">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="feature-card group">
                    <div class="feature-icon-container">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Secure Handshake</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">
                        AES-256-GCM with HKDF ratcheting, zero plaintext storage, CSRF-protected forms, and hardened CSP/HSTS headers.
                    </p>
                </div>
                <div class="feature-card group">
                    <div class="feature-icon-container">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Realtime Crypto Signals</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">
                        Live visual indicators track send, receive, and decrypt states so operators can monitor message flow instantly.
                    </p>
                </div>
                <div class="feature-card group">
                    <div class="feature-icon-container">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Ephemeral Message Lifecycle</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">
                        Rooms and messages are automatically purged by session state and burn timers to minimize persistence.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- App Integration Section -->
    <section id="app" class="py-24 px-6 relative bg-dark-950/50">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4 tracking-tight">Access the Grid</h2>
                <p class="text-gray-400 max-w-xl mx-auto">Initialize an ephemeral uplink or establish a secure handshake with an existing room.</p>
            </div>

            <div class="grid grid-cols-1 <?php echo $roomFromLink ? 'md:grid-cols-3' : 'md:grid-cols-2'; ?> gap-8 max-w-6xl mx-auto">
                <?php if ($roomFromLink): ?>
                <!-- Join via Link -->
                <div class="action-card">
                    <div class="action-card__header">
                        <div class="action-chip action-chip--link">Link detected</div>
                        <div class="action-icon">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                        </div>
                    </div>
                    <div class="action-body">
                        <h3 class="action-title">Link Handshake</h3>
                        <p class="action-sub">Establish connection for <span class="text-indigo-400 font-mono font-bold"><?php echo $roomFromLink; ?></span>. Confirm your alias to attach to this uplink.</p>
                        <div class="action-metrics">
                            <div class="metric-pill">
                                <span class="label">ROOM</span>
                                <span class="value font-mono tracking-widest"><?php echo $roomFromLink; ?></span>
                            </div>
                            <div class="metric-pill">
                                <span class="label">MODE</span>
                                <span class="value">Ephemeral</span>
                            </div>
                        </div>
                    </div>
                    
                    <form id="handshakeForm" action="join_room" method="POST" class="action-form" novalidate>
                        <input type="hidden" name="roomcode" value="<?php echo $roomFromLink; ?>">
                        <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                        <label class="action-label">
                            Alias
                            <input type="text" name="username" autocomplete="off" placeholder="Agent Alias (e.g. Neo)" class="action-input">
                        </label>
                        <button type="submit" class="action-btn action-btn--primary">Complete Handshake</button>
                        <div id="handshakeForm-error" class="error-container hidden"></div>
                    </form>
                </div>
                <?php endif; ?>

                <!-- Create Room -->
                <div class="action-card">
                    <div class="action-card__header">
                        <div class="action-chip action-chip--new">New uplink</div>
                        <div class="action-icon">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        </div>
                    </div>
                    <div class="action-body">
                        <h3 class="action-title">Create Uplink</h3>
                        <p class="action-sub">Generate a fresh 12-character room code and broadcast a clean channel for your agents.</p>
                        <div class="action-metrics">
                            <div class="metric-pill">
                                <span class="label">CODE</span>
                                <span class="value">Auto</span>
                            </div>
                            <div class="metric-pill">
                                <span class="label">SECURITY</span>
                                <span class="value">AES-256-GCM</span>
                            </div>
                        </div>
                    </div>
                    
                    <form id="createRoomForm" action="create_room" method="POST" class="action-form" novalidate>
                        <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                        <label class="action-label">
                            Alias
                            <input type="text" name="username" autocomplete="off" placeholder="Agent Alias (e.g. Neo)" class="action-input">
                        </label>
                        <button type="submit" class="action-btn action-btn--primary">Establish Secure Room</button>
                        <div id="createRoomForm-error" class="error-container hidden"></div>
                    </form>
                </div>

                <!-- Join Room -->
                <div class="action-card">
                    <div class="action-card__header">
                        <div class="action-chip action-chip--join">Existing uplink</div>
                        <div class="action-icon">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                        </div>
                    </div>
                    <div class="action-body">
                        <h3 class="action-title">Join Presence</h3>
                        <p class="action-sub">Authenticate into an active room using the shared code. Session purges on disconnect.</p>
                        <div class="action-metrics">
                            <div class="metric-pill">
                                <span class="label">SYNC</span>
                                <span class="value">Real-time</span>
                            </div>
                            <div class="metric-pill">
                                <span class="label">TTL</span>
                                <span class="value">Ephemeral</span>
                            </div>
                        </div>
                    </div>
                    
                    <form id="joinRoomForm" action="join_room" method="POST" class="action-form" novalidate>
                        <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                        <label class="action-label">
                            Alias
                            <input type="text" name="username" autocomplete="off" placeholder="Alias" class="action-input">
                        </label>
                        <label class="action-label">
                            Room Code
                            <input type="text" id="join_roomcode" name="roomcode" autocomplete="off" placeholder="XXXXXXXXXXXX" maxlength="12" class="action-input uppercase tracking-widest font-bold">
                        </label>
                        <button type="submit" class="action-btn action-btn--secondary">Synchronize Uplink</button>
                        <div id="joinRoomForm-error" class="error-container hidden"></div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-12 px-6 border-t border-white/5 bg-black/50 text-center">
        <div class="max-w-7xl mx-auto flex items-center justify-center gap-6">
            <a href="./" class="flex items-center gap-2 opacity-50 hover:opacity-100 transition-opacity">
                <img src="assets/logo.svg?v=2" alt="Nulvexor" class="w-6 h-6">
                <span class="text-sm font-bold tracking-widest">NULVEXOR</span>
            </a>
            <p class="text-xs text-gray-600">&copy; 2026 CLOAKFORT PROTOCOL</p>
        </div>
    </footer>


    <script>
        // Mobile nav toggle
        const mobileNavToggle = document.getElementById('mobileNavToggle');
        const mobileNavDrawer = document.getElementById('mobileNavDrawer');
        const mobileNavBackdrop = document.getElementById('mobileNavBackdrop');

        function closeMobileNav() {
            mobileNavDrawer.style.display = 'none';
            mobileNavBackdrop.style.display = 'none';
        }

        mobileNavToggle?.addEventListener('click', () => {
            const isOpen = mobileNavDrawer.style.display === 'flex';
            if (isOpen) {
                closeMobileNav();
            } else {
                mobileNavDrawer.style.display = 'flex';
                mobileNavBackdrop.style.display = 'block';
            }
        });

        mobileNavBackdrop?.addEventListener('click', closeMobileNav);
        document.querySelectorAll('#mobileNavDrawer a').forEach(a => {
            a.addEventListener('click', closeMobileNav);
        });

        // Ambient Cinematic Glow Controller (Cyberpunk/Enterprise-Grade)
        let glowRevertTimeout = null;
        const GLOW_STATE_CLASSES = ['state-sending', 'state-receiving', 'state-error', 'state-warning'];
        const GLOW_REVERT_MS = 4200;

        function triggerGlowState(state) {
            const wrapper = document.querySelector('.glow-ambient-wrapper');
            if (!wrapper) return;

            clearTimeout(glowRevertTimeout);

            const targetClass = state && state !== 'default' ? `state-${state}` : null;
            if (!targetClass || !GLOW_STATE_CLASSES.includes(targetClass)) {
                wrapper.classList.remove(...GLOW_STATE_CLASSES);
                return;
            }

            const otherStateClasses = GLOW_STATE_CLASSES.filter((cssClass) => cssClass !== targetClass);
            wrapper.classList.remove(...otherStateClasses);

            // Avoid remove/add flicker when the same state is re-triggered rapidly.
            if (!wrapper.classList.contains(targetClass)) {
                wrapper.classList.add(targetClass);
            }

            // Auto-revert to idle deep blue after the state color has settled.
            glowRevertTimeout = setTimeout(() => {
                wrapper.classList.remove(targetClass);
            }, GLOW_REVERT_MS);
        }

        // Professional Form Validation Logic
        const forms = ['handshakeForm', 'createRoomForm', 'joinRoomForm'];
        
        const ALERT_ICON = `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>`;


        forms.forEach(formId => {
            const form = document.getElementById(formId);
            if (!form) return;

            form.addEventListener('submit', function(e) {
                const errorContainer = document.getElementById(`${formId}-error`);
                // reset visuals
                form.querySelectorAll('input').forEach(input => input.classList.remove('input-error'));
                let isValid = true;

                if (formId === 'joinRoomForm') {
                    const username = form.querySelector('input[name="username"]').value.trim();
                    const roomcode = form.querySelector('input[name="roomcode"]').value.trim();
                    
                    if (!username && !roomcode) {
                        isValid = false;
                        form.querySelectorAll('input[name="username"], input[name="roomcode"]').forEach(i => i.classList.add('input-error'));
                    } else if (!username) {
                        isValid = false;
                        form.querySelectorAll('input[name="username"]').forEach(i => i.classList.add('input-error'));
                    } else if (!roomcode) {
                        isValid = false;
                        form.querySelectorAll('input[name="roomcode"]').forEach(i => i.classList.add('input-error'));
                    }
                } else {
                    const inputs = form.querySelectorAll('input:not([type="hidden"])');
                    inputs.forEach(input => {
                        if (!input.value.trim()) {
                            isValid = false;
                            input.classList.add('input-error');
                        }
                    });
                }

                if (!isValid) {
                    e.preventDefault();
                    errorContainer?.classList.add('hidden');
                }
            });

            // Clear error on input
            form.querySelectorAll('input').forEach(input => {
                input.addEventListener('input', () => {
                    input.classList.remove('input-error');
                    const errorContainer = document.getElementById(`${formId}-error`);
                    errorContainer?.classList.add('hidden');
                });
            });
        });

        document.getElementById('join_roomcode')?.addEventListener('input', function(e) {
            this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
        });

        // Smooth scroll for anchors
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                if (this.getAttribute('href').startsWith('#')) {
                    e.preventDefault();
                    document.querySelector(this.getAttribute('href')).scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>

    </div><!-- End desktopContent -->
</body>
</html>
