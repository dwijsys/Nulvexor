// ── Security Check ────────────────────────────────────────────────────────────
function checkSecurityContext() {
    if (window.isSecureContext === false) {
        console.error('⚠️ NULVEXOR: UNSECURE CONTEXT. Encryption may be disabled by the browser.');
        showNotification('CRITICAL: This browser blocks encryption on non-HTTPS sites. Please use localhost, 127.0.0.1, or HTTPS to enable Secret Chat.', 'error');
    }
}

// ── DOM Refs ─────────────────────────────────────────────────────────────────
const messagesArea       = document.getElementById('messagesArea');
const secretMessageForm  = document.getElementById('secretMessageForm');
const messageInput       = document.getElementById('messageInput');
const sharedKeyInput     = document.getElementById('sharedKeyInput');    // New ID
const cipherModeSelect   = document.getElementById('cipherModeSelect');  // New ID
const burnTimeSelect     = document.getElementById('burnTime');          // New ID
const sendBtn            = document.getElementById('sendBtn');
const agentsList         = document.getElementById('agentsList');
const mobileMenuToggle   = document.getElementById('mobileMenuToggle');
const mobileSidebar      = document.getElementById('mobileSidebar');
const keyError           = document.getElementById('keyError');

// ── State ─────────────────────────────────────────────────────────────────────
const displayedMessageIds = new Set();
const revealedMessages   = new Set(); // IDs of messages the user explicitly decrypted
let   autoScroll          = true;
let   isFetching          = false;
let   maxSeenIndex        = -1;
let   serverTimeOffset    = 0;
let   refreshTimeout      = null;
let   isSidebarOpen       = false;
const messageExpiries     = new Map(); // msgId -> expiryTime (unix)

// Persistent sender ID
let CURRENT_USER_ID = sessionStorage.getItem('nulv_uid') ||
    ('agent_' + Math.random().toString(36).slice(2, 9) + Date.now().toString(36));
sessionStorage.setItem('nulv_uid', CURRENT_USER_ID);

// ── Helpers ───────────────────────────────────────────────────────────────────
/**
 * Custom Notification System - Glassmorphic Toasts
 */
function showNotification(message, type = 'info', target = null) {
    let container;
    
    if (target) {
        // Remove existing inline notifications in this target
        target.querySelectorAll('.nulv-inline-notification').forEach(n => n.remove());
        container = target;
    } else {
        container = document.querySelector('.nulv-notification-container');
        if (!container) {
            container = document.createElement('div');
            container.className = 'nulv-notification-container';
            document.body.appendChild(container);
        }
    }

    const notif = document.createElement('div');
    notif.className = `nulv-notification nulv-notif-${type} ${target ? 'nulv-inline-notification' : ''}`;
    
    const icons = {
        error: '⚠️',
        warning: '⚡',
        success: '✅',
        info: 'ℹ️'
    };

    const titles = {
        error: 'PROTOCOL ERROR',
        warning: 'VERIFICATION ALERT',
        success: 'ENCRYPTION SUCCESS',
        info: 'SYSTEM LOG'
    };

    notif.innerHTML = `
        <div class="nulv-icon-box">${icons[type] || 'ℹ️'}</div>
        <div class="nulv-notif-content">
            <div class="nulv-notif-title">${titles[type] || 'System'}</div>
            <div class="nulv-notif-msg">${message}</div>
        </div>
    `;

    container.appendChild(notif);

    // Trigger animation
    requestAnimationFrame(() => {
        notif.classList.add('show');
    });

    // Auto-remove
    setTimeout(() => {
        notif.classList.remove('show');
        setTimeout(() => notif.remove(), 400);
    }, target ? 2000 : 4000);

    // Global Notification Sync with Ambient Glow
    if (!target) {
        if (type === 'error') triggerGlowState('error');
        if (type === 'warning') triggerGlowState('warning'); // Optionally we can add a warning state to ambient
    }
}

/**
 * Ambient Cinematic Glow Controller (Cyberpunk/NSA-Grade)
 */
let glowRevertTimeout = null;

function triggerGlowState(state) {
    const wrapper = document.querySelector('.glow-ambient-wrapper');
    if (!wrapper) return;

    // Clear any existing reset timer
    clearTimeout(glowRevertTimeout);
    
    // Reset to idle before applying new state
    wrapper.classList.remove('state-sending', 'state-receiving', 'state-error');
    
    // Apply state if not aiming for default
    if (state !== 'default') {
        wrapper.classList.add(`state-${state}`);
        
        // Auto-revert back to default deep blue trace after 3 seconds
        glowRevertTimeout = setTimeout(() => {
            wrapper.classList.remove(`state-${state}`);
        }, 3000);
    }
}

function escapeHtml(str) {
    const d = document.createElement('div');
    d.textContent = str;
    return d.innerHTML;
}

function formatTime(unix) {
    const d = new Date(unix * 1000);
    return `${d.getHours().toString().padStart(2,'0')}:${d.getMinutes().toString().padStart(2,'0')}`;
}

// ── Stability: Debounced Refresh ───────────────────────────────────────────────
function refreshMessages() {
    clearTimeout(refreshTimeout);
    refreshTimeout = setTimeout(() => {
        displayedMessageIds.clear();
        maxSeenIndex = -1;
        if (messagesArea) {
            const welcome = messagesArea.querySelector('.opacity-50');
            messagesArea.innerHTML = '';
            if (welcome) messagesArea.appendChild(welcome);
        }
        fetchMessages();
    }, 300);
}

// ── Messaging ─────────────────────────────────────────────────────────────────
async function fetchMessages() {
    if (isFetching) return;
    isFetching = true;
    try {
        const res = await fetch(`fetch_messages?senderId=${CURRENT_USER_ID}`);
        if (!res.ok) throw new Error(`HTTP ${res.status}`);
        const data = await res.json();
        
        if (data.status === 'success') {
            serverTimeOffset = parseInt(data.current_time) - Math.floor(Date.now() / 1000);
            
            // Handle Room Isolation
            if (data.roomcode && data.roomcode !== ROOM_CODE) {
                window.location.href = './';
                return;
            }

            for (const msg of data.messages) {
                await renderMessage(msg);
            }
            if (autoScroll && messagesArea) messagesArea.scrollTop = messagesArea.scrollHeight;
            updateAgentsList(data.messages);
        } else if (data.message === 'Room not found' || data.message === 'Room expired') {
            // [ROOM BURN SYSTEM] Redirect if room is gone
            window.location.href = './?error=RoomExpired';
        }
    } catch (e) {
        console.warn('[FETCH-RETRY] Syncing...', e.message);
    } finally {
        isFetching = false;
    }
}

function updateAgentsList(messages) {
    const users = [...new Set(messages.map(m => m.user))];
    if (agentsList) agentsList.innerHTML = users.map(user => `
        <div class="flex items-center gap-3 px-3 py-2 ${user === CURRENT_USER ? 'bg-blue-500/5 border border-blue-500/10' : ''} rounded-lg">
            <div class="w-2 h-2 rounded-full ${user === CURRENT_USER ? 'bg-blue-500 shadow-[0_0_8px_rgba(59,130,246,0.4)]' : 'bg-green-500'}"></div>
            <span class="text-sm font-medium ${user === CURRENT_USER ? 'text-white' : 'text-gray-400'}">${escapeHtml(user)}</span>
            ${user === CURRENT_USER ? '<span class="text-xs text-gray-600 font-mono ml-auto">YOU</span>' : ''}
        </div>
    `).join('');
}

async function renderMessage(msg) {
    if (displayedMessageIds.has(msg.id)) return;

    const isMine = msg.senderId === CURRENT_USER_ID;
    
    // Track Ratchet Index for V3
    try {
        const p = JSON.parse(msg.cipher);
        if (p.e2ee && p.version === 3 && typeof p.msgIndex === 'number') {
            maxSeenIndex = Math.max(maxSeenIndex, p.msgIndex);
        }
    } catch {}

    const msgDiv = document.createElement('div');
    msgDiv.id = `msg-${msg.id}`;
    msgDiv.dataset.cipher = msg.cipher;
    msgDiv.className = `flex ${isMine ? 'justify-end' : 'justify-start'} mb-6 opacity-0 transition-opacity duration-300 group`;
    
    let displayText = '';
    let isE2EE = false;
    let payload = null;

    try {
        payload = JSON.parse(msg.cipher);
        if (payload.e2ee) {
            isE2EE = true;
            const isRevealed = revealedMessages.has(msg.id);
            const pt = isRevealed ? await E2EE.decrypt(msg.cipher, sharedKeyInput.value.trim(), ROOM_CODE) : null;
            
            if (pt && !pt.includes('🔐')) {
                displayText = escapeHtml(pt);
            } else {
                const displayMode = payload.cipher || 'nsa';
                const modeLabels = {
                    'nsa': 'NSA TOP SECRET',
                    'raw': 'RAW CONFIDENTIAL',
                    'fsb': 'FSB CLASSIFIED',
                    'mossad': 'MOSSAD TARGETED',
                    'dgse': 'DGSE BITSTREAM',
                    'mi6': 'MI6 ENCRYPTED'
                };
                const modeLabel = modeLabels[displayMode] || (displayMode.toUpperCase() + ' SECURE DATA');
                
                // Use the true logic visual conversion from the payload
                const disguise = payload.visual || '[SECURE DATA]';

                displayText = `
                    <div class="flex flex-col items-start gap-2 w-full">
                         <div class="flex items-center gap-1.5 text-xs font-mono text-gray-400 uppercase tracking-widest">
                            <span class="text-blue-400 text-xs">🔒</span>
                            <span>${modeLabel}</span>
                        </div>
                        <div class="opacity-60 font-mono break-all text-[15px] leading-relaxed select-all p-2.5 rounded border border-white/5 w-full whitespace-pre-wrap">
                            ${escapeHtml(disguise)}
                        </div>
                        <div class="inline-reveal-area mt-1">
                            <button class="text-xs font-bold text-blue-400 border border-blue-500/30 px-4 py-2 rounded hover:bg-blue-600 hover:text-white transition-all uppercase reveal-trigger">
                                Decrypt & Reveal
                            </button>
                        </div>
                    </div>
                `;
            }
        } else {
            displayText = escapeHtml(msg.cipher);
        }
    } catch {
        displayText = escapeHtml(msg.cipher);
    }

    msgDiv.innerHTML = `
        <div class="flex flex-col ${isMine ? 'items-end' : 'items-start'} max-w-[85%]">
            <div class="flex items-center gap-2 mb-1 px-1">
                <span class="text-sm font-bold text-gray-400 uppercase tracking-[0.2em]">${escapeHtml(msg.user)}${isMine ? ' <span class="text-blue-500">[YOU]</span>' : ''}</span>
                <span class="text-sm font-mono text-gray-600">${formatTime(msg.time)}</span>
            </div>
            <div class="p-5 rounded-2xl ${isMine ? 'border border-blue-500/20 shadow-[0_0_20px_rgba(59,130,246,0.05)]' : 'border border-[#232329]'} relative group/bubble">
                <div class="text-lg leading-relaxed ${isE2EE && !displayText.includes('reveal-trigger') ? 'text-white' : 'text-gray-400'}">
                    ${displayText}
                    ${isE2EE && !displayText.includes('reveal-trigger') ? `
                        <div class="mt-2 pt-2 border-t border-white/5 flex items-center justify-between">
                            ${msg.burnTime > 0 ? `
                                <div class="flex items-center gap-1.5 px-2 py-1 bg-orange-500/10 border border-orange-500/20 rounded-md">
                                    <span class="text-[10px] animate-pulse">🔥</span>
                                    <span class="text-xs font-bold text-orange-400 font-mono burn-countdown" data-expiry="${parseInt(msg.time) + parseInt(msg.burnTime)}">--:--</span>
                                </div>
                            ` : '<div></div>'}
                            <button class="rehide-trigger text-xs font-bold text-gray-500 hover:text-blue-400 transition-all uppercase tracking-widest cursor-pointer">
                                ↺ Hide Again
                            </button>
                        </div>
                    ` : (msg.burnTime > 0 ? `
                        <div class="mt-2 flex justify-start">
                             <div class="flex items-center gap-1.5 px-2 py-1 bg-orange-500/10 border border-orange-500/20 rounded-md">
                                <span class="text-[10px] animate-pulse">🔥</span>
                                <span class="text-xs font-bold text-orange-400 font-mono burn-countdown" data-expiry="${parseInt(msg.time) + parseInt(msg.burnTime)}">--:--</span>
                            </div>
                        </div>
                    ` : '')}
                </div>
                ${isE2EE && !displayText.includes('reveal-trigger') ? `
                    <button class="rehide-trigger absolute -top-2 -right-2 w-5 h-5 bg-dark-700 border border-white/10 rounded-full flex items-center justify-center text-[10px] text-gray-500 hover:text-white opacity-0 group-hover/bubble:opacity-100 transition-all shadow-xl" title="Re-hide message">
                        ×
                    </button>
                ` : ''}
            </div>
        </div>
    `;

    messagesArea.appendChild(msgDiv);
    setTimeout(() => msgDiv.classList.remove('opacity-0'), 10);
    displayedMessageIds.add(msg.id);

    // Play sound for incoming messages (new ones only)
    if (!isMine && displayedMessageIds.size > 1) {
        triggerGlowState('receiving'); // Trigger green glow on receive
    }
}

function validateInputs() {
    const hasText = messageInput?.value.trim().length > 0;
    if (sendBtn) sendBtn.disabled = !hasText;
}

// ── Actions ───────────────────────────────────────────────────────────────────
secretMessageForm?.addEventListener('submit', async (e) => {
    e.preventDefault();
    const text     = messageInput.value.trim();
    const key      = sharedKeyInput.value.trim();
    const mode     = cipherModeSelect.value;
    const burn     = parseInt(burnTimeSelect.value);

    if (!text) return;

    if (!key) {
        sharedKeyInput.focus();
        sharedKeyInput.classList.add('auth-fail-effect', 'animate-shake');
        keyError?.classList.remove('hidden');
        showNotification('Shared key missing', 'warning', sharedKeyInput.parentElement);
        triggerGlowState('error'); 
        
        setTimeout(() => {
            sharedKeyInput.classList.remove('animate-shake');
        }, 1200);
        return;
    }

    sendBtn.disabled = true;
    const sendIndex = maxSeenIndex + 1;

    try {
        const encryptedPayload = await E2EE.encrypt(text, 'password', key, ROOM_CODE, sendIndex, mode);
        
        const res = await fetch('send_message', {
            method: 'POST',
            body: new URLSearchParams({
                'message': encryptedPayload,
                'cipherType': 'aes256',
                'burnTime': burn,
                'senderId': CURRENT_USER_ID
            })
        });

        if (!res.ok) throw new Error(`Server Error: ${res.status}`);
        const data = await res.json();
        
        if (data.status === 'success') {
            triggerGlowState('sending'); // Trigger blue glow on send
            messageInput.value = '';
            sharedKeyInput.value = ''; // FORCE SENDER TO RE-ENTER (Both must enter)
            validateInputs();
            fetchMessages();
        } else {
            showNotification('SEND FAILED: ' + data.message, 'error');
            triggerGlowState('error'); // Trigger red glow on error
        }
    } catch (e) {
        console.error('[SEND-ERR]', e);
        showNotification('ENCRYPTION ERROR: ' + e.message + '\n\nEnsure you are using HTTPS or localhost.', 'error');
        triggerGlowState('error'); // Trigger red glow on error
        validateInputs();
    }
});

// Handle Enter key for submission
messageInput?.addEventListener('keydown', (e) => {
    if (e.key === 'Enter' && !e.shiftKey) {
        if (sendBtn && !sendBtn.disabled) {
            e.preventDefault();
            secretMessageForm?.requestSubmit(); // Triggers the 'submit' event listener
        }
    }
});

// Handle Enter on Shared Key to focus message input
sharedKeyInput?.addEventListener('keydown', (e) => {
    if (e.key === 'Enter') {
        e.preventDefault();
        messageInput?.focus();
    }
});

// ── Interaction: Reveal & Re-hide ────────────────────────────
messagesArea?.addEventListener('click', async e => {
    // 1. Reveal Plaintext (Now with Inline Entry)
    if (e.target.classList.contains('reveal-trigger')) {
        const area = e.target.closest('.inline-reveal-area');
        const globalKey = sharedKeyInput.value.trim();

        if (!globalKey) {
            // IN-CHAT ENTRY: Switch button to input field (no prompt!)
            area.innerHTML = `
                <div class="inline-entry-container flex flex-col gap-1.5 mt-1 animate-fade-in">
                    <div class="flex items-center gap-1">
                        <input type="password" class="inline-key-input w-28 bg-black/60 border border-blue-500/30 rounded px-2.5 py-1.5 text-[11px] text-white outline-none focus:border-blue-500 transition-all" placeholder="DECRYPT KEY...">
                        <button class="inline-confirm-btn bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded text-[10px] font-bold shadow-lg shadow-blue-500/20 transition-all uppercase tracking-wider">GO</button>
                    </div>
                    <div class="error-msg hidden text-[9px] font-bold text-red-500 flex items-center gap-1 px-1 uppercase tracking-widest">
                        <span class="animate-pulse">⚠</span> Authentication Failed
                    </div>
                </div>
            `;
            const input = area.querySelector('.inline-key-input');
            const btn = area.querySelector('.inline-confirm-btn');
            input.focus();

            // Clear error on type
            input.addEventListener('input', () => {
                input.classList.remove('auth-fail-effect');
                btn?.classList.remove('auth-fail-btn');
                area.querySelector('.error-msg')?.classList.add('hidden');
            });
            
            // Handle 'Enter' inside the tiny input
            input.addEventListener('keydown', ek => {
                if (ek.key === 'Enter') area.querySelector('.inline-confirm-btn').click();
            });
            return;
        }
        
        const msgId = e.target.closest('[id^="msg-"]').id.replace('msg-', '');
        revealedMessages.add(msgId);
        refreshMessages();
    }

    // Handle Inline Confirmation
    if (e.target.classList.contains('inline-confirm-btn')) {
        const input = e.target.parentElement.querySelector('.inline-key-input');
        const k = input.value.trim();
        if (k) {
            // Validation: Quick test decryption
            const msgDiv = e.target.closest('[id^="msg-"]');
            const cipher = msgDiv.dataset.cipher;
            const testPt = await E2EE.decrypt(cipher, k, ROOM_CODE);

            if (testPt.includes('🔐')) {
                const container = e.target.closest('.inline-entry-container');
                const input = container.querySelector('.inline-key-input');
                const errorLabel = container.querySelector('.error-msg');
                
                const btn = container.querySelector('.inline-confirm-btn');
                
                input.classList.add('auth-fail-effect');
                btn?.classList.add('auth-fail-btn');
                errorLabel.classList.remove('hidden');
                triggerGlowState('error');
                
                // Shake effect
                container.classList.add('animate-shake');
                setTimeout(() => container.classList.remove('animate-shake'), 400);

                input.focus();
                return;
            }

            sharedKeyInput.value = k;
            validateInputs();
            const msgId = msgDiv.id.replace('msg-', '');
            revealedMessages.add(msgId);
            refreshMessages();
        }
    }

    // 2. Re-hide Toggle
    if (e.target.classList.contains('rehide-trigger')) {
        const msgId = e.target.closest('[id^="msg-"]').id.replace('msg-', '');
        revealedMessages.delete(msgId);
        
        // Security: Clear the shared key input so they must enter it again
        if (sharedKeyInput) {
            sharedKeyInput.value = '';
            validateInputs();
        }
        
        refreshMessages();
    }
});

sharedKeyInput?.addEventListener('input', () => {
    validateInputs();
    // Clear error state on type
    keyError?.classList.add('hidden');
    sharedKeyInput?.classList.remove('auth-fail-effect');
});

messageInput?.addEventListener('input', validateInputs);

cipherModeSelect?.addEventListener('change', refreshMessages);

// ── Burn Logic ──────────────────────────────────────────────────────────────
function updateBurnTimers() {
    const now = Math.floor(Date.now() / 1000) + serverTimeOffset;
    document.querySelectorAll('.burn-countdown').forEach(el => {
        const expiry = parseInt(el.dataset.expiry);
        const remaining = expiry - now;

        if (remaining <= 0) {
            const msgDiv = el.closest('[id^="msg-"]');
            if (msgDiv) {
                msgDiv.style.opacity = '0';
                msgDiv.style.transform = 'scale(0.95)';
                setTimeout(() => msgDiv.remove(), 300);
            }
        } else {
            const m = Math.floor(remaining / 60);
            const s = remaining % 60;
            el.textContent = `${m}:${s.toString().padStart(2, '0')}`;
        }
    });
}

// ── Sidebar ──────────────────────────────────────────────────────────────────
mobileMenuToggle?.addEventListener('click', () => {
    isSidebarOpen = !isSidebarOpen;
    mobileSidebar?.classList.toggle('-translate-x-full', !isSidebarOpen);
    
    // Toggle Icons
    document.getElementById('menuIcon')?.classList.toggle('hidden', isSidebarOpen);
    document.getElementById('closeIcon')?.classList.toggle('hidden', !isSidebarOpen);
});

// Close sidebar on message area click (Mobile)
messagesArea?.addEventListener('click', () => {
    if (window.innerWidth < 768 && isSidebarOpen) {
        isSidebarOpen = false;
        mobileSidebar?.classList.add('-translate-x-full');
        document.getElementById('menuIcon')?.classList.remove('hidden');
        document.getElementById('closeIcon')?.classList.add('hidden');
    }
});

// Handle window resize
window.addEventListener('resize', () => {
    if (window.innerWidth >= 768) {
        mobileSidebar?.classList.remove('-translate-x-full');
    } else if (!isSidebarOpen) {
        mobileSidebar?.classList.add('-translate-x-full');
    }
});

// ── Disconnect Logic (Room Burn System) ──────────────────────────────────────
function burnRoomAndDisconnect() {
    const data = new FormData();
    data.append('roomcode', ROOM_CODE);
    navigator.sendBeacon('disconnect-room', data);
}

// Monitor for page exit / visibility change
window.addEventListener('pagehide', burnRoomAndDisconnect);
window.addEventListener('visibilitychange', () => {
    if (document.visibilityState === 'hidden') {
        // Optional: you could burn here too, but pagehide is safer for 'close'
    }
});

// Handle 'Disconnect' link manual click
document.querySelector('a[href="./"]')?.addEventListener('click', (e) => {
    burnRoomAndDisconnect();
});

// ── Init ──────────────────────────────────────────────────────────────────────
setInterval(fetchMessages, 3000);
setInterval(updateBurnTimers, 1000);
fetchMessages();
checkSecurityContext();

messagesArea?.addEventListener('scroll', () => {
    const { scrollTop, scrollHeight, clientHeight } = messagesArea;
    autoScroll = scrollHeight - scrollTop - clientHeight < 80;
});

console.log('🚀 NULVEXOR ENGINE v5.1 HARMONIZED — STANDBY');
