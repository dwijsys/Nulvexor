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
            border-color: var(--accent-blue) !important;
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
    </style>
</head>
<body class="bg-[#07070a] text-gray-300 min-h-screen guide-gradient overflow-x-hidden">
    
    <!-- Header -->
    <header class="py-12 px-6 border-b border-white/5 bg-black/40 backdrop-blur-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <a href="./" class="flex items-center gap-3 group">
                <img src="assets/logo.svg?v=2" alt="Nulvexor" class="w-10 h-10 group-hover:rotate-12 transition-transform">
                <span class="text-xl font-bold tracking-tighter text-white">NULVEXOR <span class="text-indigo-400 font-light ml-2">GUIDE</span></span>
            </a>
            <div class="flex items-center gap-4">
                <a href="https://github.com/dwijsys" target="_blank" class="flex items-center gap-2 px-5 py-2.5 bg-indigo-500/10 border border-indigo-500/30 text-white font-bold rounded-full hover:bg-indigo-600 hover:border-indigo-400 hover:shadow-[0_0_20px_rgba(99,102,241,0.4)] transition-all uppercase tracking-widest text-xs group">
                    <svg class="w-4 h-4 text-indigo-400 group-hover:text-white transition-colors" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.008.069-.008 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" /></svg>
                    <span class="hidden sm:inline">GitHub</span>
                </a>
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
                Complete intelligence on establishing secure uplinks, managing cryptographic keys, and utilizing agency-grade protocols.
            </p>
        </div>

        <!-- Section 1: Quick Setup -->
        <div class="mb-32">
            <div class="flex items-center gap-4 mb-12">
                <div class="h-px flex-1 bg-gradient-to-r from-transparent to-white/5"></div>
                <h2 class="text-2xl font-bold text-white uppercase tracking-widest shrink-0">01. Connection Protocol</h2>
                <div class="h-px flex-1 bg-gradient-to-l from-transparent to-white/5"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                <!-- Step 1 -->
                <div class="step-card p-8 rounded-3xl bg-white/5 relative overflow-hidden group">
                    <div class="text-7xl font-black text-indigo-400 absolute top-2 right-4 opacity-[0.02] blur-md group-hover:opacity-100 group-hover:blur-none transition-all duration-700 select-none pointer-events-none">1</div>
                    <div class="w-12 h-12 rounded-xl bg-indigo-500/10 flex items-center justify-center text-indigo-400 mb-6 font-bold">A</div>
                    <h3 class="text-xl font-bold text-white mb-4">Initialize Connection</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">Create an ephemeral room to generate a 6-character code, or join an existing session by entering a code shared by your contact. An Alias is required for identification.</p>
                </div>

                <!-- Step 2 -->
                <div class="step-card p-8 rounded-3xl bg-white/5 relative overflow-hidden group">
                    <div class="text-7xl font-black text-indigo-400 absolute top-2 right-4 opacity-[0.02] blur-md group-hover:opacity-100 group-hover:blur-none transition-all duration-700 select-none pointer-events-none">2</div>
                    <div class="w-12 h-12 rounded-xl bg-indigo-500/10 flex items-center justify-center text-indigo-400 mb-6 font-bold">B</div>
                    <h3 class="text-xl font-bold text-white mb-4">Secure & Burn Protocol</h3>
                    <p class="text-sm text-gray-500 leading-relaxed mb-4">Enter a shared password to synchronize the E2EE channel. Use the 🔥 icon to instantly purge the room for all participants.</p>
                    <p class="text-[10px] text-indigo-400 font-mono tracking-widest uppercase opacity-70">Note: If no shared key is established, decode via cipher method manually.</p>
                </div>
            </div>
        </div>

        <!-- Section 2: Security Levels -->
        <div class="mb-32">
             <div class="flex items-center gap-4 mb-12">
                <div class="h-px flex-1 bg-gradient-to-r from-transparent to-white/5"></div>
                <h2 class="text-2xl font-bold text-white uppercase tracking-widest shrink-0">02. Encryption Specs</h2>
                <div class="h-px flex-1 bg-gradient-to-l from-transparent to-white/5"></div>
            </div>

            <div class="glass-panel p-1 border border-white/5 rounded-[2.5rem]">
                <div class="bg-[#0b0b0f] rounded-[2.2rem] overflow-hidden">
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
                                        <div class="w-3 h-3 rounded-full bg-indigo-400 shadow-[0_0_10px_rgba(99,102,241,1)]"></div>
                                        <span class="text-white font-bold">AES-256-GCM</span>
                                    </div>
                                </td>
                                <td class="p-8 text-gray-400">NSA, RAW, Mossad</td>
                                <td class="p-8"><span class="px-3 py-1 bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 text-[10px] font-bold rounded-full">LEVEL 5 — TOP SECRET</span></td>
                            </tr>
                            <tr class="border-b border-white/5 hover:bg-white/5 transition-colors group">
                                <td class="p-8">
                                    <div class="flex items-center gap-4">
                                        <div class="w-3 h-3 rounded-full bg-indigo-400 shadow-[0_0_10px_rgba(99,102,241,1)]"></div>
                                        <span class="text-white font-bold">HKDF-SHA256</span>
                                    </div>
                                </td>
                                <td class="p-8 text-gray-400">Signal, WhatsApp E2EE</td>
                                <td class="p-8"><span class="px-3 py-1 bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 text-[10px] font-bold rounded-full">RATCHETING SESSIONS</span></td>
                            </tr>
                            <tr class="hover:bg-white/5 transition-colors group">
                                <td class="p-8">
                                    <div class="flex items-center gap-4">
                                        <div class="w-3 h-3 rounded-full bg-indigo-400 shadow-[0_0_10px_rgba(129,140,248,1)]"></div>
                                        <span class="text-white font-bold">Web Crypto API</span>
                                    </div>
                                </td>
                                <td class="p-8 text-gray-400">Native Browser Hardware</td>
                                <td class="p-8"><span class="px-3 py-1 bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 text-[10px] font-bold rounded-full">ZERO KNOWLEDGE</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Section 3: Visual Modes -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center mb-32">
            <div>
                <h2 class="text-3xl font-bold text-white mb-6 uppercase tracking-tight">Visual <span class="text-indigo-400">Disguise</span> Engines</h2>
                <p class="text-gray-500 leading-relaxed mb-8">
                    Nulvexor allows hardware-accelerated AES ciphertext to be wrapped in various classical ciphers. This provides an additional layer of obfuscation against visual surveillance.
                </p>
                <ul class="space-y-4">
                    <li class="flex items-center gap-3 text-sm">
                        <svg class="w-5 h-5 text-indigo-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span><strong class="text-white">True Morse</strong> — Reversible dot-dash conversion.</span>
                    </li>
                    <li class="flex items-center gap-3 text-sm">
                        <svg class="w-5 h-5 text-indigo-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span><strong class="text-white">Vigenere / Atbash</strong> — Classical letter substitution.</span>
                    </li>
                    <li class="flex items-center gap-3 text-sm">
                        <svg class="w-5 h-5 text-indigo-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span><strong class="text-white">Z-Cipher</strong> — Custom visual pattern masking.</span>
                    </li>
                </ul>
            </div>
            <div class="relative">
                <div class="absolute -inset-4 bg-indigo-500/10 blur-3xl rounded-full"></div>
                <div class="relative glass-panel p-8 font-mono text-xs space-y-4 border border-indigo-500/20">
                    <p class="text-indigo-400/60 pb-2 border-b border-white/5">CIPHER PREVIEW (V3.5):</p>
                    <p class="text-white break-all leading-6 opacity-30">.... . .-.. .-.. --- / .--. .-. --- - --- -.-. --- .-..</p>
                    <p class="text-indigo-400 break-all leading-6 animate-pulse">[RATCHET ROTATED: SUCCESS]</p>
                    <p class="text-indigo-400 break-all leading-6">S3f9+K2L8w9M1n0P... (AUTHENTICATED)</p>
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
