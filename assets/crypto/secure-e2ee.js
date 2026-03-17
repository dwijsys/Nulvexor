/**
 * ╔══════════════════════════════════════════════════════════╗
 * ║     NULVEXOR SECRET CHAT E2EE — Security Module v5.0     ║
 * ║     AES-256-GCM + PBKDF2 (Shared-Key Model)              ║
 * ╚══════════════════════════════════════════════════════════╝
 */

const NULVEXOR_SECRET_CHAT_E2EE = (() => {
    'use strict';

    const enc = new TextEncoder();
    const dec = new TextDecoder();

    // ── Helpers ─────────────────────────────────────────────────────────────
    function bufToB64(buf)  { return btoa(String.fromCharCode(...new Uint8Array(buf))).replace(/\+/g, '-').replace(/\//g, '_').replace(/=+$/, ''); }
    function b64ToBuf(b64)  { return Uint8Array.from(atob(b64.replace(/-/g, '+').replace(/_/g, '/')), c => c.charCodeAt(0)); }

    /**
     * Derives a 256-bit AES key from a shared secret and roomId.
     * Uses PBKDF2-SHA256 with 100,000 iterations.
     */
    async function deriveSharedKey(sharedKey, roomId) {
        const pwKey = await crypto.subtle.importKey(
            'raw', 
            enc.encode(sharedKey), 
            'PBKDF2', 
            false, 
            ['deriveKey']
        );
        
        return crypto.subtle.deriveKey(
            { 
                name: 'PBKDF2', 
                salt: enc.encode(roomId), 
                iterations: 100000, 
                hash: 'SHA-256' 
            },
            pwKey,
            { name: 'AES-GCM', length: 256 },
            false,
            ['encrypt', 'decrypt']
        );
    }

    /**
     * Generates a 96-bit crypto-secure random nonce.
     */
    function generateNonce() {
        return crypto.getRandomValues(new Uint8Array(12));
    }

    /**
     * Applies a visual cipher display to a string.
     */
    function applyCipherDisplay(text, mode) {
        switch (mode) {
            case 'symbol':
                return text.split('').map(c => {
                    const symbols = '✦⌬⟁⌬✦⟁⌬∑∏Ωαβγδεζηθικλμνξοπρστυφχψω';
                    return symbols[c.charCodeAt(0) % symbols.length];
                }).join('');
            case 'glyph':
                return text.split('').map(c => {
                    const glyphs = 'ᚠᚡᚢᚣᚤᚥᚦᚧᚨᚩᚪᚫᚬᚭᚮᚯᚰᚱᚲᚳᚴᚵᚶᚷᚸᚹᚺᚻᚼᚽᚾᚿ';
                    return glyphs[c.charCodeAt(0) % glyphs.length];
                }).join('');
            case 'base64':
                return btoa(text);
            default:
                return text;
        }
    }

    /**
     * Encrypts plaintext using AES-256-GCM.
     */
    async function encryptMessage(plaintext, sharedKey, roomId, cipherMode = 'aes') {
        const key   = await deriveSharedKey(sharedKey, roomId);
        const nonce = generateNonce();
        
        const ptBytes = enc.encode(plaintext);
        const ctBuf   = await crypto.subtle.encrypt(
            { name: 'AES-GCM', iv: nonce, tagLength: 128 },
            key,
            ptBytes
        );

        const payload = {
            e2ee: true,
            version: 2,
            cipher: cipherMode,
            nonce: bufToB64(nonce),
            ct: bufToB64(ctBuf),
            ts: Date.now()
        };

        return payload;
    }

    /**
     * Decrypts a cipher payload using AES-256-GCM.
     */
    async function decryptMessage(payload, sharedKey, roomId) {
        try {
            const key = await deriveSharedKey(sharedKey, roomId);
            const ptBuf = await crypto.subtle.decrypt(
                { name: 'AES-GCM', iv: b64ToBuf(payload.nonce), tagLength: 128 },
                key,
                b64ToBuf(payload.ct)
            );
            return dec.decode(ptBuf);
        } catch (e) {
            throw new Error('decryption_failed');
        }
    }

    /**
     * Suggestions to clear key from memory.
     * In JS, we can't truly wipe memory, but we can overwrite references.
     */
    function clearKeyFromMemory(keyVar) {
        if (typeof keyVar === 'string') {
            return '';
        }
        return null;
    }

    return {
        deriveSharedKey,
        encryptMessage,
        decryptMessage,
        generateNonce,
        applyCipherDisplay,
        clearKeyFromMemory
    };
})();

window.NULVEXOR_SECRET_CHAT_E2EE = NULVEXOR_SECRET_CHAT_E2EE;
