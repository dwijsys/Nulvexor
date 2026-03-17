<?php
// chat.php
session_start();

// [ROOM BURN SYSTEM] Prevent caching of the chat page to ensure history navigation checks file existence
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if (!isset($_SESSION['username']) || !isset($_SESSION['roomcode'])) {
    header('Location: ./');
    exit;
}

$username = htmlspecialchars($_SESSION['username']);
$roomCode = htmlspecialchars($_SESSION['roomcode']);

// [ROOM BURN SYSTEM] Check if room still exists
$filePath = __DIR__ . '/rooms/' . $roomCode . '.json';
if (!file_exists($filePath)) {
    // Redirect to home with expired error
    header('Location: ./?error=RoomExpired');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nulvexor — [<?php echo $roomCode; ?>]</title>
    <link rel="icon" type="image/svg+xml" href="assets/favicon.svg?v=2">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet">
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
                            600: '#232329',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                        mono: ['IBM Plex Mono', 'monospace'],
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-[#0b0b0f] text-white h-dvh overflow-hidden flex flex-col">
    <!-- Premium Ambient Glow System -->
    <div class="glow-ambient-wrapper"></div>
    
    <!-- Design Elements -->
    <div class="grid-background opacity-10"></div>

    <!-- Navbar -->
    <nav class="nav-glass w-full z-50 px-6 flex-shrink-0">
        <div class="max-w-7xl mx-auto nav-height flex items-center justify-between">
            <div class="flex items-center gap-6">
                <a href="./" class="flex items-center gap-3">
                    <img src="assets/logo.svg?v=2" alt="Nulvexor" class="w-7 h-7">
                    <span class="text-sm font-bold tracking-tight text-white hidden sm:block">NULVEXOR</span>
                </a>
                <div class="h-4 w-px bg-[#232329]"></div>
                <div class="flex items-center gap-2">
                    <span class="text-xs font-bold text-indigo-400 tracking-widest uppercase bg-indigo-500/10 px-2 py-0.5 rounded border border-indigo-500/20">Active Channel</span>
                    <span class="text-sm font-mono text-gray-500 tracking-widest"><?php echo $roomCode; ?></span>
                </div>
            </div>
            
            <div class="flex items-center gap-4">
            <div class="flex items-center gap-4">
                <div class="hidden md:flex items-center gap-2 px-3 py-1.5 bg-[#16161a] border border-[#232329] rounded-lg">
                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span>
                    <span class="text-[11px] font-medium text-gray-400">ENCRYPTED UPLINK</span>
                </div>
                <a href="./" class="text-xs font-semibold text-red-400 hover:text-red-300 transition-colors">Disconnect</a>
            </div>
        </div>
    </nav>

    <div class="flex flex-1 overflow-hidden">
        <!-- Sidebar -->
        <aside id="mobileSidebar" class="w-64 md:w-72 bg-[#111114]/90 backdrop-blur-xl border-r border-[#232329] flex flex-col transform md:translate-x-0 transition-transform duration-300 ease-in-out">
            <div class="p-6">
                <h4 class="text-[11px] font-bold text-gray-500 mb-6 tracking-[0.2em] uppercase">Connectors</h4>
                
                <div class="space-y-1" id="agentsList">
                    <!-- Agent item template -->
                    <div class="flex items-center gap-3 px-3 py-2 bg-indigo-500/5 border border-indigo-500/10 rounded-lg">
                        <div class="w-2 h-2 rounded-full bg-indigo-500"></div>
                        <span class="text-xs font-medium text-white"><?php echo $username; ?></span>
                        <span class="text-[10px] text-gray-600 font-mono ml-auto">YOU</span>
                    </div>
                </div>
            </div>

            <div class="mt-auto p-6 border-t border-[#232329]">
                <div class="glass-panel p-4 space-y-3">
                    <p class="text-[10px] font-bold text-gray-500 tracking-widest uppercase">System Stats</p>
                    <div class="flex justify-between text-[10px]">
                        <span class="text-gray-400">Latency</span>
                        <span class="text-green-400 font-mono">24ms</span>
                    </div>
                    <div class="flex justify-between text-[10px]">
                        <span class="text-gray-400">Algorithm</span>
                        <span class="text-indigo-400 font-mono">AES-256</span>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Chat Area -->
        <main class="flex-1 flex flex-col min-w-0 bg-[#0b0b0f] relative">
            <!-- Messages Area -->
            <div id="messagesArea" class="flex-1 overflow-y-auto p-6 space-y-6 no-scrollbar scroll-smooth">
                <!-- Welcome Message -->
                <div class="flex flex-col items-center justify-center py-10 opacity-50">
                    <div class="w-12 h-12 rounded-2xl bg-[#16161a] border border-[#232329] flex items-center justify-center text-gray-400 mb-4">🔐</div>
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-widest">End-to-End Encrypted Room</p>
                    <p class="text-[10px] text-gray-600 font-mono mt-2">UUID: <?php echo bin2hex(random_bytes(8)); ?></p>
                </div>
            </div>

            <!-- Input Area -->
            <div class="p-4 sm:p-6 pt-0 flex-shrink-0">
                <div class="max-w-4xl mx-auto space-y-4">
                    <!-- NEW SECRET CHAT SYSTEM UI -->
                    <div id="secretChatPanel" class="glass-panel p-4 border border-indigo-500/20 bg-indigo-500/5 rounded-xl space-y-4">
                        <div class="flex flex-wrap items-end gap-4">
                            <!-- Shared Key Input -->
                            <div class="flex-1 min-w-[200px] relative">
                                <label class="text-[11px] font-bold text-purple-400 uppercase tracking-widest mb-1 block ml-1">Encryption Key</label>
                                <input type="password" id="sharedKeyInput" placeholder="Enter dragon-4821 style key..." 
                                    class="w-full bg-black/40 border border-[#232329] rounded-lg px-4 py-3 text-sm text-white placeholder-gray-600 focus:border-indigo-500/50 outline-none transition-all">
                            </div>

                            <!-- Cipher Mode Selector -->
                            <div class="relative">
                                <label class="text-[11px] font-bold text-gray-500 uppercase tracking-widest mb-1 block ml-1">Cipher Mode</label>
                                <select id="cipherModeSelect" class="bg-black/40 border border-[#232329] rounded-lg px-3 py-3 text-sm text-gray-300 focus:border-indigo-500/50 outline-none cursor-pointer">
                                    <option value="nsa">NSA (AES-GCM)</option>
                                    <option value="raw">RAW (Morse Logic)</option>
                                    <option value="fsb">FSB (Serpent Glyphs)</option>
                                    <option value="mossad">MOSSAD (High-Entropy)</option>
                                    <option value="dgse">DGSE (Bitstream)</option>
                                    <option value="mi6">MI6 (Standard Base64)</option>
                                </select>
                            </div>

                             <!-- Burn Timer -->
                             <div class="relative">
                                <label class="text-[11px] font-bold text-orange-500 uppercase tracking-widest mb-1 block ml-1">Auto Burn</label>
                                <select id="burnTime" class="bg-black/40 border border-[#232329] rounded-lg px-3 py-3 text-sm text-gray-300 focus:border-indigo-500/50 outline-none cursor-pointer">
                                    <option value="0">Disabled</option>
                                    <option value="30">30 Seconds</option>
                                    <option value="60">1 Minute</option>
                                    <option value="300">5 Minutes</option>
                                    <option value="900">15 Minutes</option>
                                </select>
                            </div>
                        </div>

                        <!-- Message Input Form -->
                        <form id="secretMessageForm" class="relative" novalidate>
                            <input type="text" id="messageInput" autocomplete="off" placeholder="Type a message to encrypt..." required 
                                class="w-full h-14 bg-black/60 border border-indigo-500/20 focus:border-indigo-500/50 rounded-lg px-5 py-3 text-base text-white placeholder-gray-600 outline-none transition-all pr-12 sm:pr-44">
                            <div class="absolute right-1.5 top-1.5">
                                <button type="submit" id="sendBtn" disabled class="h-11 w-11 sm:w-auto px-0 sm:px-6 flex items-center justify-center sm:gap-2 bg-indigo-500/10 text-white border border-indigo-500/20 rounded-md text-xs font-bold uppercase tracking-widest hover:bg-[#0d0d12] hover:border-indigo-500 hover:shadow-[0_0_20px_rgba(99,102,241,0.4)] transition-all disabled:opacity-30 disabled:cursor-not-allowed">
                                    <span class="hidden sm:inline">Send Encrypted</span>
                                    <svg class="w-4 h-4 sm:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="assets/e2ee.js"></script>
    <script src="assets/script.js"></script>
</body>
</html>
