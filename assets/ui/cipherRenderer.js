/**
 * UI Component for rendering encrypted messages with visual styles.
 */

const CipherRenderer = (() => {
    'use strict';

    function renderEncrypted(payload) {
        const mode = payload.cipher || 'aes';
        let visualText = '';

        if (mode === 'aes' || mode === 'chacha') {
            visualText = payload.ct.substring(0, 32) + '...';
        } else {
            // Decrypt the visual part for display purposes if it's symbol/glyph/base64
            // but since we want it to look "encrypted", we use the ciphertext as source
            visualText = NULVEXOR_SECRET_CHAT_E2EE.applyCipherDisplay(payload.ct.substring(0, 16), mode);
        }

        return `
            <div class="cipher-container font-mono text-xs opacity-80 break-all">
                <div class="flex items-center gap-2 mb-1">
                    <span class="px-1.5 py-0.5 bg-blue-500/20 text-blue-400 rounded uppercase text-[9px] font-bold tracking-widest">${mode}</span>
                    <span class="text-gray-600">ENCRYPTED PAYLOAD</span>
                </div>
                <div class="cipher-blob p-2 rounded border border-white/5 text-gray-400">
                    ${visualText}
                </div>
                <button class="mt-2 w-full py-1.5 hover:bg-blue-500/10 text-blue-400 border border-blue-500/30 rounded text-[10px] font-bold uppercase tracking-wider transition-all decrypt-trigger" data-payload='${JSON.stringify(payload)}'>
                    Unlock Message
                </button>
            </div>
        `;
    }

    return { renderEncrypted };
})();

window.CipherRenderer = CipherRenderer;
