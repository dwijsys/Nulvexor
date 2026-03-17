<?php
// index.php
session_start();
$roomFromLink = isset($_GET['room']) ? htmlspecialchars($_GET['room']) : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <!-- Design Elements -->
    <div class="grid-background"></div>
    <div class="radial-glow top-0 left-1/4 -translate-x-1/2 opacity-50"></div>
    <div class="radial-glow bottom-0 right-0 opacity-30"></div>

    <!-- Navbar -->
    <nav class="nav-glass fixed top-0 w-full z-50 px-6 box-border">
        <div class="max-w-7xl mx-auto nav-height flex items-center justify-between">
            <div class="flex items-center gap-8">
                <a href="./" class="flex items-center gap-3 group">
                    <img src="assets/logo.svg?v=2" alt="Nulvexor" class="w-10 h-10 group-hover:rotate-12 transition-transform duration-300">
                    <span class="text-xl font-bold tracking-tighter text-white">NULVEXOR</span>
                </a>
                <div class="hidden md:flex items-center gap-6">
                    <a href="./" class="text-sm font-medium text-gray-400 hover:text-white transition-colors">Home</a>
                    <a href="#features" class="text-sm font-medium text-gray-400 hover:text-white transition-colors">Protocols</a>
                    <a href="guide" class="flex items-center gap-1 text-sm font-medium text-indigo-400 hover:text-indigo-300 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        User Guide
                    </a>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <a href="https://github.com/dwijsys" target="_blank" class="flex items-center gap-2 btn-secondary text-xs py-2 px-4 h-10 group/gh hover:scale-105 transition-all">
                    <svg class="w-5 h-5 text-gray-400 group-hover/gh:text-white transition-colors" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.008.069-.008 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" /></svg>
                    <span class="hidden sm:inline">GitHub</span>
                </a>
            </div>
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
                    Nulvexor implements Zero-Knowledge end-to-end encryption with HKDF-SHA256 ratcheting. Your keys, your secrets, impossible to decrypt.
                </p>
                <div class="flex flex-wrap items-center justify-center lg:justify-start gap-4">
                    <a href="#app" class="glass-panel px-8 py-4 h-14 text-base flex items-center justify-center font-bold text-white transition-preset border border-white/5 gap-2 group">
                        <svg class="w-5 h-5 text-indigo-400 transition-colors group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        Initial Connection
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
                    <h3 class="text-xl font-bold text-white mb-3">Agency-Grade E2EE</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">
                        Utilizes AES-256-GCM, the gold standard for NSA and RAW Top-Secret communications. No server-side keys. No backdoors.
                    </p>
                </div>
                <div class="feature-card group">
                    <div class="feature-icon-container">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Symmetric Ratchet</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">
                        Features HKDF-SHA256 key rotation. Each message has a unique cryptographic signature, ensuring perfect forward secrecy across the session.
                    </p>
                </div>
                <div class="feature-card group">
                    <div class="feature-icon-container">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Visual Obfuscation</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">
                        Toggle between Morse, Atbash, or Vigenere cipher displays. Hidden in plain sight, your data remains secured by industrial-grade crypto.
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
                <div class="glass-panel p-8 group transition-preset relative overflow-hidden active-card">
                    <div class="absolute top-0 right-0 p-4 opacity-[0.02] group-hover:opacity-[0.04] transition-opacity bg-icon-container">
                        <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M3.9 12c0-1.71 1.39-3.1 3.1-3.1h4V7H7c-2.76 0-5 2.24-5 5s2.24 5 5 5h4v-1.9H7c-1.71 0-3.1-1.39-3.1-3.1zM8 13h8v-2H8v2zm9-6h-4v1.9h4c1.71 0 3.1 1.39 3.1 3.1s-1.39 3.1-3.1 3.1h-4V17h4c2.76 0 5-2.24 5-5s-2.24-5-5-5z"/></svg>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-indigo-500/10 flex items-center justify-center text-indigo-400 mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Link Handshake</h3>
                    <p class="text-sm text-gray-500 mb-8 leading-relaxed">Establish connection for room <span class="text-indigo-400 font-mono font-bold"><?php echo $roomFromLink; ?></span>. Identification required.</p>
                    
                    <form id="handshakeForm" action="join_room" method="POST" class="space-y-4" novalidate>
                        <input type="hidden" name="roomcode" value="<?php echo $roomFromLink; ?>">
                        <div class="relative">
                            <input type="text" name="username" autocomplete="off" placeholder="Agent Alias (e.g. Neo)" class="w-full bg-[#16161a] border border-[#232329] focus:border-indigo-500/50 rounded-lg px-4 py-3 text-sm text-white placeholder-gray-600 outline-none transition-all">
                        </div>
                        <button type="submit" class="w-full btn-primary h-12">Complete Handshake</button>
                        <div id="handshakeForm-error" class="error-container hidden"></div>
                    </form>
                </div>
                <?php endif; ?>

                <!-- Create Room -->
                <div class="glass-panel p-8 group transition-preset relative overflow-hidden active-card">
                    <div class="absolute top-0 right-0 p-4 opacity-[0.02] group-hover:opacity-[0.04] transition-opacity bg-icon-container">
                        <img src="assets/logo.svg?v=2" class="w-32 h-32 grayscale invert">
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-indigo-500/10 flex items-center justify-center text-indigo-400 mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Create Uplink</h3>
                    <p class="text-sm text-gray-500 mb-8 leading-relaxed">Enter your agent alias; a unique 6-character room code will be generated automatically to establish your secure channel.</p>
                    
                    <form id="createRoomForm" action="create_room" method="POST" class="space-y-4" novalidate>
                        <div class="relative">
                            <input type="text" name="username" autocomplete="off" placeholder="Agent Alias (e.g. Neo)" class="w-full bg-[#16161a] border border-[#232329] focus:border-indigo-500/50 rounded-lg px-4 py-3 text-sm text-white placeholder-gray-600 outline-none transition-all">
                        </div>
                        <button type="submit" class="w-full btn-primary h-12">Establish Secure Room</button>
                        <div id="createRoomForm-error" class="error-container hidden"></div>
                    </form>
                </div>

                <!-- Join Room -->
                <div class="glass-panel p-8 group transition-preset relative overflow-hidden active-card">
                    <div class="absolute top-0 right-0 p-4 opacity-[0.02] group-hover:opacity-[0.04] transition-opacity bg-icon-container">
                        <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M11 7L9.6 8.4l2.6 2.6H2v2h10.2l-2.6 2.6L11 17l5-5-5-5zm9 12h-8v2h8c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-8v2h8v14z"/></svg>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-indigo-500/10 flex items-center justify-center text-indigo-400 mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Join Presence</h3>
                    <p class="text-sm text-gray-500 mb-8 leading-relaxed">Enter an existing room code to synchronize with other agents currently on the channel.</p>
                    
                    <form id="joinRoomForm" action="join_room" method="POST" class="space-y-4" novalidate>
                        <div class="grid grid-cols-2 gap-3">
                            <input type="text" name="username" autocomplete="off" placeholder="Alias" class="bg-[#16161a] border border-[#232329] focus:border-indigo-500/50 rounded-lg px-4 py-3 text-sm text-white placeholder-gray-600 outline-none transition-all">
                            <input type="text" id="join_roomcode" name="roomcode" autocomplete="off" placeholder="CODE" maxlength="6" class="bg-[#16161a] border border-[#232329] focus:border-indigo-500/50 rounded-lg px-4 py-3 text-sm text-white placeholder-gray-600 outline-none transition-all uppercase tracking-widest font-bold">
                        </div>
                        <button type="submit" class="w-full btn-secondary h-12">Synchronize Uplink</button>
                        <div id="joinRoomForm-error" class="error-container hidden"></div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-12 px-6 border-t border-white/5 bg-black/50 text-center">
        <div class="max-w-7xl mx-auto flex flex-col items-center gap-6">
            <a href="./" class="flex items-center gap-2 opacity-50 hover:opacity-100 transition-opacity">
                <img src="assets/logo.svg?v=2" alt="Nulvexor" class="w-6 h-6">
                <span class="text-sm font-bold tracking-widest">NULVEXOR</span>
            </a>
            <p class="text-xs text-gray-600">© 2026 Nulvexor Protocol — Zero Knowledge Platform</p>
            <div class="flex items-center gap-6">
                <a href="guide" class="text-xs font-bold text-gray-500 hover:text-white transition-colors uppercase tracking-widest">Operational Manual</a>
            </div>
        </div>
    </footer>


    <script>
        // Professional Form Validation Logic
        const forms = ['handshakeForm', 'createRoomForm', 'joinRoomForm'];
        
        const ALERT_ICON = `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>`;

        forms.forEach(formId => {
            const form = document.getElementById(formId);
            if (!form) return;

            form.addEventListener('submit', function(e) {
                const errorContainer = document.getElementById(`${formId}-error`);
                let isValid = true;
                let errorMessage = "";

                if (formId === 'joinRoomForm') {
                    const username = form.querySelector('input[name="username"]').value.trim();
                    const roomcode = form.querySelector('input[name="roomcode"]').value.trim();
                    
                    if (!username && !roomcode) {
                        isValid = false;
                        errorMessage = "ROOM CODE AND IDENTIFICATION REQUIRED";
                    } else if (!username) {
                        isValid = false;
                        errorMessage = "IDENTIFICATION REQUIRED";
                    } else if (!roomcode) {
                        isValid = false;
                        errorMessage = "ROOM CODE REQUIRED";
                    }
                } else {
                    const inputs = form.querySelectorAll('input:not([type="hidden"])');
                    inputs.forEach(input => {
                        if (!input.value.trim()) {
                            isValid = false;
                            if (input.name === 'username') errorMessage = "IDENTIFICATION REQUIRED";
                            else if (input.name === 'roomcode') errorMessage = "ROOM CODE REQUIRED";
                        }
                    });
                }

                if (!isValid) {
                    e.preventDefault();
                    // Inject premium alert structure
                    errorContainer.innerHTML = `
                        <div class="nulv-alert">
                            ${ALERT_ICON}
                            <span>${errorMessage}</span>
                        </div>
                    `;
                    errorContainer.classList.remove('hidden');
                    
                    // Re-trigger animation if already visible
                    const alert = errorContainer.querySelector('.nulv-alert');
                    alert.style.animation = 'none';
                    alert.offsetHeight; // trigger reflow
                    alert.style.animation = null;
                }
            });

            // Clear error on input
            form.querySelectorAll('input').forEach(input => {
                input.addEventListener('input', () => {
                    const errorContainer = document.getElementById(`${formId}-error`);
                    errorContainer.classList.add('hidden');
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
</body>
</html>
