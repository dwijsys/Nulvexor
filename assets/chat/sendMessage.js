/**
 * Logic for sending encrypted messages.
 */

const SendMessageModule = (() => {
    'use strict';

    async function send(plaintext, sharedKey, roomId, cipherMode, burnTime, currentUserId) {
        if (!plaintext || !sharedKey) return;

        try {
            // 1. Encrypt
            const payload = await NULVEXOR_SECRET_CHAT_E2EE.encryptMessage(plaintext, sharedKey, roomId, cipherMode);
            
            // 2. Transmit
            const res = await fetch('send_message', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    message: JSON.stringify(payload),
                    burnTime,
                    senderId: currentUserId
                })
            });

            if (!res.ok) throw new Error('Network error');
            const result = await res.json();

            // 3. Clear key from memory (best effort)
            sharedKey = NULVEXOR_SECRET_CHAT_E2EE.clearKeyFromMemory(sharedKey);

            return result;
        } catch (e) {
            console.error('[SEND-ERR]', e);
            throw e;
        }
    }

    return { send };
})();

window.SendMessageModule = SendMessageModule;
