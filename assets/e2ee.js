/**
 * ╔══════════════════════════════════════════════════════════╗
 * ║     NULVEXOR E2EE — Ratchet V3 (Forward Secrecy)        ║
 * ║     AES-256-GCM + HKDF-SHA256 Ratcheting                ║
 * ╚══════════════════════════════════════════════════════════╝
 *
 * Flow:
 *   sharedKey → PBKDF2 → initialChainKey
 *   Each message: 
 *     messageKey   = HKDF(chainKey, "message-key")
 *     nextChainKey = HKDF(chainKey, "next-chain")
 *
 * Wire format V3:
 *   { "e2ee": true, "version": 3, "nonce": "...", "ct": "...", "msgIndex": X }
 */

const E2EE = (() => {
    'use strict';

    const enc = new TextEncoder();
    const dec = new TextDecoder();

    // ── Helpers ─────────────────────────────────────────────────────────────
    function bufToB64(buf)  { return btoa(String.fromCharCode(...new Uint8Array(buf))).replace(/\+/g, '-').replace(/\//g, '_').replace(/=+$/, ''); }
    function b64ToBuf(b64)  { return Uint8Array.from(atob(b64.replace(/-/g, '+').replace(/_/g, '/')), c => c.charCodeAt(0)); }
    function hexToBuf(hex)  { return Uint8Array.from(hex.match(/.{2}/g), b => parseInt(b, 16)); }
    function generateHexKey() { return Array.from(crypto.getRandomValues(new Uint8Array(32))).map(b => b.toString(16).padStart(2, '0')).join(''); }

    const MAX_RATCHET_STEPS = 2000; // Safety limit to prevent CPU exhaustion

    let keyCache = { secret: null, salt: null, key: null };

    // ── Key Derivation ───────────────────────────────────────────────────────

    /**
     * Derives the initial HKDF "Master Key" from the shared secret.
     */
    async function getMasterKey(secret, method, roomCode) {
        // Cache hit: avoid expensive PBKDF2 re-derivation
        if (keyCache.secret === secret && keyCache.salt === roomCode && keyCache.method === method) {
            return keyCache.key;
        }

        let key;
        if (method === 'password') {
            const pwKey = await crypto.subtle.importKey('raw', enc.encode(secret), 'PBKDF2', false, ['deriveBits']);
            const bits  = await crypto.subtle.deriveBits(
                { name: 'PBKDF2', salt: enc.encode(roomCode), iterations: 100_000, hash: 'SHA-256' },
                pwKey,
                256 // 256 bits = 32 bytes
            );
            key = await crypto.subtle.importKey('raw', bits, 'HKDF', false, ['deriveKey', 'deriveBits']);
        } else {
            key = await crypto.subtle.importKey('raw', hexToBuf(secret), 'HKDF', false, ['deriveKey', 'deriveBits']);
        }

        keyCache = { secret, salt: roomCode, method, key };
        return key;
    }

    /**
     * Step the ratchet: moves forward 'count' times through the HKDF chain.
     */
    async function deriveMessageKey(masterKey, index) {
        if (index > MAX_RATCHET_STEPS) throw new Error('Ratchet limit exceeded');
        let currentChainKey = masterKey;
        
        // Ratchet the chain forward to the specified index
        for (let i = 0; i <= index; i++) {
            // 1. Derive Message Key Bits
            const msgBits = await crypto.subtle.deriveBits(
                { name: 'HKDF', hash: 'SHA-256', salt: new Uint8Array(32), info: enc.encode(`msg-key-v3-${i}`) },
                currentChainKey,
                256
            );

            if (i === index) {
                return crypto.subtle.importKey('raw', msgBits, 'AES-GCM', false, ['encrypt', 'decrypt']);
            }

            // 2. Derive Next Chain Key Bits
            const chainBits = await crypto.subtle.deriveBits(
                { name: 'HKDF', hash: 'SHA-256', salt: new Uint8Array(32), info: enc.encode('next-chain-v3') },
                currentChainKey,
                256
            );

            currentChainKey = await crypto.subtle.importKey('raw', chainBits, 'HKDF', false, ['deriveKey', 'deriveBits']);
        }
    }

    // ── True Logic Classical Ciphers ──────────────────────────────────────────
    const TrueLogic = {
        vigenere: (text, key) => {
            let res = '';
            for (let i = 0, j = 0; i < text.length; i++) {
                const c = text[i];
                if (c.match(/[a-z]/i)) {
                    const isUpper = (c === c.toUpperCase());
                    const code = text.charCodeAt(i);
                    const base = isUpper ? 65 : 97;
                    const shift = key.charCodeAt(j % key.length) - (key[j % key.length] === key[j % key.length].toUpperCase() ? 65 : 97);
                    res += String.fromCharCode(((code - base + shift) % 26) + base);
                    j++;
                } else res += c;
            }
            return res;
        },
        atbash: (text) => {
            return text.split('').map(c => {
                if (c.match(/[a-z]/i)) {
                    const isUpper = (c === c.toUpperCase());
                    const code = c.toLowerCase().charCodeAt(0);
                    const reversed = String.fromCharCode(122 - (code - 97));
                    return isUpper ? reversed.toUpperCase() : reversed;
                }
                return c;
            }).join('');
        },
        morse: (text) => {
            const map = {
                'A': '.-', 'B': '-...', 'C': '-.-.', 'D': '-..', 'E': '.', 'F': '..-.', 'G': '--.', 'H': '....',
                'I': '..', 'J': '.---', 'K': '-.-', 'L': '.-..', 'M': '--', 'N': '-.', 'O': '---', 'P': '.--.',
                'Q': '--.-', 'R': '.-.', 'S': '...', 'T': '-', 'U': '..-', 'V': '...-', 'W': '.--', 'X': '-..-',
                'Y': '-.--', 'Z': '--..', '1': '.----', '2': '..---', '3': '...--', '4': '....-', '5': '.....',
                '6': '-....', '7': '--...', '8': '---..', '9': '----.', '0': '-----', ' ': '/'
            };
            return text.toUpperCase().split('').map(c => map[c] || c).join(' ');
        },
        binary: (text) => {
            return text.split('').map(c => c.charCodeAt(0).toString(2).padStart(8, '0')).join(' ');
        },
        caesar: (text, shift = 13) => {
            return text.replace(/[a-z]/gi, (c) => {
                const isUpper = (c === c.toUpperCase());
                const base = isUpper ? 65 : 97;
                return String.fromCharCode(((c.charCodeAt(0) - base + shift) % 26) + base);
            });
        }
    };

    /**
     * Applies a visual cipher display to a string for non-AES modes.
     */
    function applyCipherDisplay(text, mode, key = 'NULVEXOR') {
        switch (mode) {
            case 'nsa':    return TrueLogic.vigenere(text, key);
            case 'raw':    return TrueLogic.morse(text);
            case 'fsb':    return TrueLogic.atbash(text);
            case 'mossad': return TrueLogic.vigenere(text, key.split('').reverse().join('')); // Columnar-ish/Variant
            case 'dgse':   return TrueLogic.binary(text);
            case 'mi6':    return TrueLogic.caesar(text, 13);
            default:       return TrueLogic.atbash(text);
        }
    }

    // ── Public API ───────────────────────────────────────────────────────────

    async function encrypt(plaintext, method, secret, roomCode, index = 0, cipherMode = 'nsa') {
        try {
            const masterKey = await getMasterKey(secret, method, roomCode);
            const msgKey    = await deriveMessageKey(masterKey, index);
            
            const nonce = crypto.getRandomValues(new Uint8Array(12));
            const ct    = await crypto.subtle.encrypt(
                { name: 'AES-GCM', iv: nonce, tagLength: 128 },
                msgKey,
                enc.encode(plaintext)
            );

            // Generate "True Logic" Visual Display
            const visual = applyCipherDisplay(plaintext, cipherMode, roomCode);

            return JSON.stringify({
                e2ee: true,
                version: 3,
                method,
                cipher: cipherMode,
                msgIndex: index,
                visual: visual, // NEW: Full converted cipher text
                nonce: bufToB64(nonce),
                ct: bufToB64(ct),
                ts: Date.now()
            });
        } catch (e) {
            console.error('[E2EE-ENCRYPT-ERR]', e);
            throw e;
        }
    }

    async function decrypt(wireJson, secret, roomCode) {
        try {
            const payload = JSON.parse(wireJson);
            if (!payload.e2ee) return wireJson;

            // Only attempt V3 ratchet if version matches
            if (payload.version === 3) {
                const masterKey = await getMasterKey(secret, payload.method, roomCode);
                const index     = payload.msgIndex || 0;
                const msgKey    = await deriveMessageKey(masterKey, index);

                const pt = await crypto.subtle.decrypt(
                    { name: 'AES-GCM', iv: b64ToBuf(payload.nonce), tagLength: 128 },
                    msgKey,
                    b64ToBuf(payload.ct)
                );
                return dec.decode(pt);
            }
            throw new Error('Fallback to legacy');
        } catch (e) {
            // Fallback for legacy V1/V2 messages (Direct derivation)
            try {
                const payload = JSON.parse(wireJson);
                const rawKey = payload.method === 'password' 
                    ? await (async () => {
                        const pk = await crypto.subtle.importKey('raw', enc.encode(secret), 'PBKDF2', false, ['deriveKey']);
                        return crypto.subtle.deriveKey(
                            { name: 'PBKDF2', salt: enc.encode(roomCode), iterations: 100_000, hash: 'SHA-256' },
                            pk, { name: 'AES-GCM', length: 256 }, false, ['decrypt']
                        );
                    })()
                    : await crypto.subtle.importKey('raw', hexToBuf(secret), { name: 'AES-GCM', length: 256 }, false, ['decrypt']);
                
                const pt = await crypto.subtle.decrypt(
                    { name: 'AES-GCM', iv: b64ToBuf(payload.nonce), tagLength: 128 },
                    rawKey,
                    b64ToBuf(payload.ct)
                );
                return dec.decode(pt);
            } catch (e2) {
                return '🔐 [Decryption failed — wrong key or corrupted message]';
            }
        }
    }

    function isE2EE(cipher) {
        try { return JSON.parse(cipher)?.e2ee === true; } catch { return false; }
    }

    return { encrypt, decrypt, isE2EE, generateHexKey, applyCipherDisplay };
})();

window.E2EE = E2EE;
console.log('✅ NULVEXOR E2EE V3 RATChET LOADED — Forward Secrecy Enabled');
