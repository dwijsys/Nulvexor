/**
 * UI Component for manual decryption key entry.
 */

const DecryptModal = (() => {
    'use strict';

    function createModal(onUnlock) {
        const modalId = 'decrypt-modal-' + Math.random().toString(36).substr(2, 9);
        const html = `
            <div id="${modalId}" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm">
                <div class="glass-panel w-full max-w-sm p-6 scale-in">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-lg bg-blue-500/10 flex items-center justify-center text-blue-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-white font-bold">Decrypt Message</h3>
                            <p class="text-[10px] text-gray-500 uppercase tracking-widest">Manual Key Required</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1.5 ml-1">Shared Key</label>
                            <input type="password" id="${modalId}-input" placeholder="Enter key to unlock..." 
                                class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-3 text-sm text-white placeholder-gray-600 outline-none focus:border-blue-500/50 transition-all">
                        </div>

                        <div class="flex gap-2">
                            <button class="flex-1 py-3 bg-gray-600/20 hover:bg-gray-600/30 text-gray-400 rounded-lg text-xs font-bold uppercase tracking-widest transition-all cancel-btn">Cancel</button>
                            <button class="flex-[2] py-3 bg-blue-600 hover:bg-blue-500 text-white rounded-lg text-xs font-bold uppercase tracking-widest transition-all shadow-lg shadow-blue-500/20 unlock-btn">Unlock</button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        document.body.insertAdjacentHTML('beforeend', html);
        const modal = document.getElementById(modalId);
        const input = document.getElementById(`${modalId}-input`);

        const close = () => {
            modal.classList.add('opacity-0');
            setTimeout(() => modal.remove(), 200);
        };

        modal.querySelector('.cancel-btn').onclick = close;
        modal.querySelector('.unlock-btn').onclick = () => {
            const key = input.value.trim();
            if (key) {
                onUnlock(key);
                // Clear key from input
                input.value = '';
                close();
            }
        };

        input.onkeydown = (e) => {
            if (e.key === 'Enter') modal.querySelector('.unlock-btn').click();
            if (e.key === 'Escape') close();
        };

        input.focus();
    }

    return { createModal };
})();

window.DecryptModal = DecryptModal;
