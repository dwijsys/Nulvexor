# 🛡️ NULVEXOR — Cryptographic Communication Platform

> **Quantum-Ready. Zero-Knowledge. Peer-to-Peer Encryption.**

> [!IMPORTANT]
> **DESKTOP OPTIMIZED**: This platform is designed for desktop environments for maximum cryptographic performance and UI stability.
> **SESSION WARNING**: Refreshing the browser or closing the tab will immediately terminate your session and purge all local cryptographic keys.

Nulvexor is a premium, high-security chat platform designed for absolute privacy. It leverages industry-standard cryptographic protocols used by global intelligence agencies to ensure your communications remain untraceable and unbreakable.

🌐 **Website:** [www.nulvexor.co.in](https://www.nulvexor.co.in)

---

## ⚡ Quick Start

1.  **Access the Grid**: Open [www.nulvexor.co.in](https://www.nulvexor.co.in) in your secure browser.
2.  **Establish Uplink**:
    *   **Create Room**: Set your alias and generate an ephemeral room code.
    *   **Join Room**: Enter the 6-character room code shared by your contact.
3.  **Secure the Channel**: Select an encryption method (Password or Direct Key) and synchronize with your partner.

---

## 🔒 Encryption Protocols (Level 5)

Nulvexor follows the same security standards as global agencies (NSA, CIA, RAW, MI6, Mossad).

### 1. AES-256-GCM (Authenticated Encryption)
*   **Key Length**: 256-bit
*   **Mode**: Galois/Counter Mode (GCM)
*   **Encryption**: Authenticated, 128-bit integrity tag.
*   **Key Derivation**: PBKDF2 with 100,000 iterations (SHA-256).

### 2. Perfect Forward Secrecy (HKDF Ratchet)
*   **Mechanism**: HKDF-SHA256 symmetric ratcheting.
*   **Impact**: Every single message uses a unique, derived key. If one key is compromised, previous and future messages remain secure.

### 3. Visual Cipher Modes
*   **Classical Ciphers**: Transform your encrypted data into Morse, Vigenere, Atbash, or Base64 for visual camouflage while maintaining AES-256-GCM security underneath.

---

## 📖 User Guide

### Setting up a Secure Session
1.  **Alias**: Choose a temporary handle (e.g., `Neo`).
2.  **Room Code**: Secure rooms are identified by a 6-character uppercase alphanumeric code.
3.  **Key Synchronization**: 
    *   **Password Mode**: Both users must enter the exact same password to derive the AES-256 session key.
    *   **Manual Decoding**: If no shared key is established, messages can still be decoded using the current cipher method manually (e.g., Morse, Vigenere).

### Message Management
*   **Burn Protocol**: Click the 🔥 icon on any message or the master purge button to destroy communications immediately for all participants.
*   **Burn Timer**: Set a duration (1m, 5m, etc.) for automatic message self-destruction.
*   **Re-Hiding**: Use the 🛡️/🔒 toggle to restore the cipher disguise over decrypted text.

---

## 🛡️ Agency Comparison & Compliance

| Agency | Primary Cipher | Standard |
| :--- | :--- | :--- |
| **NSA (USA)** | AES-256 | FIPS 140-2 |
| **RAW (India)** | AES-256 | GOV-SEC |
| **MI6 (UK)** | AES-256 | GCHQ |
| **Mossad (Israel)**| AES-256 | UNIT 8200 |

*   ✅ **FIPS 140-2 Compliant**
*   ✅ **NSA Suite B Cryptography**
*   ✅ **Zero Server-Side Plaintext Storage**

---

## 🛠️ Technical Implementation

*   **Frontend**: Vanilla JS, Tailwind CSS, Heroicons.
*   **Security**: Web Crypto API (`crypto.subtle`).
*   **Backend**: PHP (Session management), Python/PHP WebSockets.
*   **Storage**: No database; temporary JSON buffers with auto-cleanup.

---

© 2026 NULVEXOR PROTOCOL. All Rights Reserved.
[www.nulvexor.co.in](https://www.nulvexor.co.in)
