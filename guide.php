<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nulvexor — Operational Intelligence Guide</title>
    <link rel="icon" type="image/svg+xml" href="assets/favicon.svg?v=2">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/custom.css">
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .guide-gradient {
            background: radial-gradient(circle at top right, rgba(99, 102, 241, 0.05), transparent),
                        radial-gradient(circle at bottom left, rgba(99, 102, 241, 0.05), transparent);
        }
        .step-card {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        .step-card:hover {
            transform: translateY(-4px) scale(1.01) !important;
            border-color: #6366f1 !important;
            background: #0d0d12 !important;
            box-shadow: 0 0 30px rgba(99, 102, 241, 0.4) !important;
        }
        .step-card:hover * {
            color: white !important;
        }
        .cipher-badge {
            font-family: 'Courier New', monospace;
            letter-spacing: 2px;
        }
        .glow-text {
            text-shadow: 0 0 20px rgba(99, 102, 241, 0.5);
        }
        .status-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 8px;
        }
    </style>
</head>
<body class="bg-[#07070a] text-gray-300 min-h-screen guide-gradient overflow-x-hidden">
    <!-- Premium Ambient Glow System -->
    <div class="glow-ambient-wrapper"></div>
    
    <!-- Header -->
    <header class="py-12 px-6 border-b border-white/5 bg-black/40 backdrop-blur-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <a href="./" class="flex items-center gap-3 group">
                <img src="assets/logo.svg?v=2" alt="Nulvexor" class="w-10 h-10 group-hover:rotate-12 transition-transform">
                <span class="text-xl font-bold tracking-tighter text-white">NULVEXOR <span class="text-indigo-400 font-light ml-2">GUIDE</span></span>
            </a>
            <div class="flex items-center gap-4">
                <a href="./" class="text-sm font-bold text-gray-500 hover:text-white transition-colors uppercase tracking-widest flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Return to Grid
                </a>
            </div>
        </div>
    </header>

    <main class="max-w-6xl mx-auto py-20 px-6">
        <!-- Hero Title -->
        <div class="text-center mb-24 animate-fade-in">
            <h1 class="text-5xl md:text-6xl font-black text-white mb-6 tracking-tight glow-text uppercase">
                Operational <span class="text-indigo-400">Manual</span>
            </h1>
            <p class="text-xl text-gray-500 max-w-2xl mx-auto leading-relaxed">
                Everything you need to know about navigating the Nulvexor secure grid, visual state indicators, and encryption flows.
            </p>
        </div>

        <!-- Section 1: Connection Protocol (Simplified) -->
        <div class="mb-32">
            <div class="flex items-center gap-4 mb-12">
                <div class="h-px flex-1 bg-gradient-to-r from-transparent to-white/5"></div>
                <h2 class="text-2xl font-bold text-white uppercase tracking-widest shrink-0">01. Getting Started</h2>
                <div class="h-px flex-1 bg-gradient-to-l from-transparent to-white/5"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Step 1 -->
                <div class="step-card p-6 rounded-3xl bg-white/5 relative overflow-hidden group">
                    <div class="w-10 h-10 rounded-xl bg-indigo-500/10 flex items-center justify-center text-indigo-400 mb-6 font-bold">1</div>
                    <h3 class="text-lg font-bold text-white mb-2 uppercase">Initial Uplink</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">Choose an "Alias" (your temporary name) and either <strong>Create</strong> a new room or <strong>Join</strong> an existing one via a 6-character code.</p>
                </div>

                <!-- Step 2 -->
                <div class="step-card p-6 rounded-3xl bg-white/5 relative overflow-hidden group">
                    <div class="w-10 h-10 rounded-xl bg-indigo-500/10 flex items-center justify-center text-indigo-400 mb-6 font-bold">2</div>
                    <h3 class="text-lg font-bold text-white mb-2 uppercase">Secure Handshake</h3>
                    <p class="text-sm text-gray-500 leading-relaxed mb-4">Once in the room, sync with your partner using a <strong>shared password</strong>. This derives your unique AES-256 session key locally on your device.</p>
                    <p class="text-[10px] text-indigo-400 font-mono tracking-widest uppercase opacity-70">Note: If no shared key is established, messages can be decoded manually via the active cipher method.</p>
                </div>

                <!-- Step 3 -->
                <div class="step-card p-6 rounded-3xl bg-white/5 relative overflow-hidden group">
                    <div class="w-10 h-10 rounded-xl bg-indigo-500/10 flex items-center justify-center text-indigo-400 mb-6 font-bold">3</div>
                    <h3 class="text-lg font-bold text-white mb-2 uppercase">Full Transmission</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">Type your message and hit send. No data is ever stored on the server as plaintext. Every byte is encrypted before it leaves your browser.</p>
                </div>
            </div>
        </div>


        <!-- Section 3: Critical Intelligence (Desktop & Refresh) -->
        <div class="mb-32">
             <div class="flex items-center gap-4 mb-12">
                <div class="h-px flex-1 bg-gradient-to-r from-transparent to-white/5"></div>
                <h2 class="text-2xl font-bold text-white uppercase tracking-widest shrink-0">03. Critical Security Notice</h2>
                <div class="h-px flex-1 bg-gradient-to-l from-transparent to-white/5"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="p-8 rounded-[2.5rem] bg-indigo-500/5 border border-indigo-500/10">
                    <div class="inline-flex items-center gap-2 text-indigo-400 font-bold uppercase tracking-widest mb-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        Desktop Optimized
                    </div>
                    <p class="text-sm text-gray-400 leading-relaxed mb-4">
                        Nulvexor is engineered for **Desktop Environments**. For maximum performance of the Web Crypto API and to experience the full immersive cinematic UI, we recommend using a modern desktop browser (Chrome, Edge, or Firefox).
                    </p>
                    <p class="text-[10px] text-gray-600 font-mono italic">MOBILE DEVICES MAY EXPERIENCE REDUCED GLOW FIDELITY.</p>
                </div>

                <div class="p-8 rounded-[2.5rem] bg-red-500/5 border border-red-500/10">
                    <div class="inline-flex items-center gap-2 text-red-500 font-bold uppercase tracking-widest mb-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                        Refresh Termination
                    </div>
                    <p class="text-sm text-gray-400 leading-relaxed mb-4">
                        This is a <strong>Zero-Knowledge</strong> platform. We store nothing in databases. If you refresh the page or close the tab, your session is immediately destroyed.
                    </p>
                    <p class="text-[10px] text-red-400 font-mono tracking-widest uppercase">⚠️ REFRESHING WILL END THE CHAT FOR YOU PERMANENTLY.</p>
                </div>
            </div>
        </div>

        <!-- Section 4: Security Features Table -->
        <div class="mb-32">
             <div class="flex items-center gap-4 mb-12">
                <div class="h-px flex-1 bg-gradient-to-r from-transparent to-white/5"></div>
                <h2 class="text-2xl font-bold text-white uppercase tracking-widest shrink-0">04. Encryption Specs</h2>
                <div class="h-px flex-1 bg-gradient-to-l from-transparent to-white/5"></div>
            </div>

            <div class="glass-panel p-1 border border-white/5 rounded-[2.5rem] overflow-hidden">
                <div class="bg-[#0b0b0f] rounded-[2.2rem] overflow-hidden overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-white/5">
                                <th class="p-8 text-xs font-bold text-gray-500 uppercase tracking-widest">Protocol</th>
                                <th class="p-8 text-xs font-bold text-gray-500 uppercase tracking-widest">Used By</th>
                                <th class="p-8 text-xs font-bold text-gray-500 uppercase tracking-widest">Classification</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-white/5 hover:bg-white/5 transition-colors group">
                                <td class="p-8">
                                    <div class="flex items-center gap-4">
                                        <div class="status-dot bg-indigo-500"></div>
                                        <span class="text-white font-bold text-sm sm:text-base">AES-256-GCM</span>
                                    </div>
                                </td>
                                <td class="p-8 text-gray-400 text-sm">NSA, TOP-SECRET Clearance</td>
                                <td class="p-8"><span class="px-3 py-1 bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 text-[10px] font-bold rounded-full uppercase">LEVEL 5 ACCESS</span></td>
                            </tr>
                            <tr class="border-b border-white/5 hover:bg-white/5 transition-colors group">
                                <td class="p-8">
                                    <div class="flex items-center gap-4">
                                        <div class="status-dot bg-indigo-400"></div>
                                        <span class="text-white font-bold text-sm sm:text-base">HKDF-SHA256</span>
                                    </div>
                                </td>
                                <td class="p-8 text-gray-400 text-sm">Industrial Handshake Sync</td>
                                <td class="p-8"><span class="px-3 py-1 bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 text-[10px] font-bold rounded-full uppercase">RATCHETING SESSION</span></td>
                            </tr>
                            <tr class="hover:bg-white/5 transition-colors group">
                                <td class="p-8">
                                    <div class="flex items-center gap-4">
                                        <div class="status-dot bg-indigo-400"></div>
                                        <span class="text-white font-bold text-sm sm:text-base">Visual Ciphers</span>
                                    </div>
                                </td>
                                <td class="p-8 text-gray-400 text-sm">Obfuscation Camouflage</td>
                                <td class="p-8"><span class="px-3 py-1 bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 text-[10px] font-bold rounded-full uppercase">VISUAL MASKING</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="text-center py-20 bg-gradient-to-b from-white/5 to-transparent rounded-[3rem] border border-white/5">
            <h2 class="text-3xl font-bold text-white mb-6 uppercase">Ready to Initialize?</h2>
            <a href="./" class="inline-flex items-center gap-2 px-10 py-4 bg-indigo-500/10 text-white border border-indigo-500/30 font-black rounded-full hover:bg-[#0d0d12] hover:border-indigo-500 hover:shadow-[0_0_25px_rgba(99,102,241,0.3)] hover:translate-y-[-2px] transition-all uppercase tracking-widest text-sm">
                Access the Grid Now
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            </a>
        </div>
    </main>

    <footer class="py-12 px-6 border-t border-white/5 text-center mt-20">
        <p class="text-xs text-gray-600 tracking-widest uppercase">© 2026 NULVEXOR PROTOCOL — ABSOLUTE SECRECY GUARANTEED</p>
    </footer>

</body>
</html>
