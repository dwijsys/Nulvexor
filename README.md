# 🛡️ NULVEXOR — Cryptographic Communication Platform

> **Zero-Knowledge · End-to-End Encrypted · Ephemeral by Design**

Nulvexor is a real-time, database-free encrypted chat platform. Messages are encrypted client-side with **AES-256-GCM** and an **HKDF-SHA256 ratchet** (forward secrecy), transmitted as opaque ciphertext, and stored temporarily in flat JSON files that auto-purge. The server never sees plaintext.

🌐 **Live:** [www.nulvexor.co.in](https://www.nulvexor.co.in)

---

## ⚡ Quick Start

1. Open [nulvexor.co.in](https://www.nulvexor.co.in) on a desktop browser.
2. **Create a Room** — pick an alias, and a 12-character room code is auto-generated.
3. Share the room code (or the direct join link) with your contact.
4. Both users enter the **same encryption key** (password or raw hex) — keys never leave the browser.
5. Chat. Every message gets a unique derived key via HKDF ratcheting.

---

## 🏗️ Project Structure

```
Nulvexor/
├── index.php              # Landing page — create / join room forms
├── room.php               # Chat room UI (messages, encryption panel, sidebar)
├── guide.php              # User guide / documentation page
├── security.php           # Centralized security helpers (session, CSRF, CSP, HSTS)
├── create_room.php        # POST — generates a 12-char room code & JSON file
├── join_room.php          # POST — validates code, attaches user to room session
├── send_message.php       # POST — appends E2EE ciphertext to room JSON
├── fetch_messages.php     # GET  — returns messages, handles heartbeat & burn timers
├── destroy_room.php       # POST — deletes room file & destroys session
├── disconnect-room.php    # POST — immediate room destruction on disconnect
├── verify_decrypt_code.php# POST — server-side decrypt-code verification
├── .htaccess              # Apache rewrites (clean URLs, .php extension removal)
├── Dockerfile             # PHP 8.3 + Apache — configured for Render (port 10000)
├── render.yaml            # Render deployment manifest
├── Procfile               # Process declaration for platform hosting
├── package.json           # Project metadata & npm dependencies
│
├── assets/
│   ├── e2ee.js            # E2EE crypto engine — AES-256-GCM + HKDF-SHA256 ratchet
│   ├── script.js          # Chat UI logic — polling, message rendering, burn system
│   ├── custom.css         # Core design system — dark theme, glassmorphism, animations
│   ├── style.css          # Additional styles
│   ├── menu.css           # Mobile navigation styles
│   ├── logo.svg           # Nulvexor logo
│   └── favicon.svg        # Browser favicon
│
├── rooms/                 # Ephemeral room data (JSON files, gitignored)
└── sessions/              # PHP session storage
```

---

## 🔒 Encryption Architecture

All encryption runs **entirely in the browser** via the [Web Crypto API](https://developer.mozilla.org/en-US/docs/Web/API/Web_Crypto_API) (`crypto.subtle`). The server only stores and relays opaque ciphertext.

### AES-256-GCM (Authenticated Encryption)

| Parameter       | Value                                       |
| :-------------- | :------------------------------------------ |
| Algorithm       | AES-256-GCM                                 |
| Key Length       | 256-bit                                     |
| IV / Nonce       | 12 bytes (96-bit), random per message       |
| Auth Tag         | 128-bit GCM integrity tag                   |
| Key Derivation   | PBKDF2 — 100,000 iterations, SHA-256 (password mode) |

### HKDF-SHA256 Ratchet (Forward Secrecy)

Each message derives a **unique key** from a ratcheting chain:

```
sharedKey → PBKDF2 → masterChainKey
  ├── HKDF(chainKey, "msg-key-v3-0")  → messageKey₀  (encrypt msg #0)
  ├── HKDF(chainKey, "next-chain-v3") → chainKey₁
  ├── HKDF(chainKey₁, "msg-key-v3-1") → messageKey₁  (encrypt msg #1)
  └── ... (up to 2,000 ratchet steps)
```

Compromising one message key does **not** expose past or future messages.

### Key Input Modes

| Mode         | How It Works                                                  |
| :----------- | :------------------------------------------------------------ |
| **Password** | User enters a passphrase → PBKDF2 (100k iterations) → master key |
| **Direct Key** | User provides a 64-char hex key (256-bit) directly             |

### Visual Cipher Modes

On top of the AES-256-GCM core, messages can be displayed through a secondary visual cipher layer for camouflage:

| Mode            | Cipher Logic                 |
| :-------------- | :--------------------------- |
| AES-GCM         | Vigenère substitution        |
| Morse Logic      | Morse code encoding          |
| Serpent Glyphs   | Atbash mirror cipher         |
| High-Entropy     | Reversed Vigenère variant    |
| Bitstream        | Binary (8-bit) encoding      |
| Standard Base64  | ROT-13 / Caesar shift        |

> These are **display-only transforms**. The actual security comes from AES-256-GCM underneath.

### Wire Format (V3)

```json
{
  "e2ee": true,
  "version": 3,
  "method": "password",
  "cipher": "aes",
  "msgIndex": 42,
  "visual": ".- -... -.-.",
  "nonce": "url-safe-base64",
  "ct": "url-safe-base64",
  "ts": 1715500000000
}
```

---

## 🛡️ Server-Side Security

Centralized in `security.php`:

- **Secure Sessions** — `HttpOnly`, `SameSite=Strict`, `Secure` (when HTTPS), auto-regeneration
- **CSRF Protection** — 256-bit token on all state-changing forms, validated via `hash_equals()`
- **Rate Limiting** — 2-second cooldown on room create/join actions
- **Content Security Policy** — `default-src 'self'`, whitelisted CDN for Tailwind + Google Fonts
- **HTTP Headers** — `X-Frame-Options: DENY`, `X-Content-Type-Options: nosniff`, `Referrer-Policy: same-origin`, `Permissions-Policy` (camera/mic/geo blocked)
- **HSTS** — `max-age=31536000; includeSubDomains; preload` (when HTTPS)
- **Input Sanitization** — `htmlspecialchars()` for aliases, regex whitelist for room codes (`[A-Z0-9]`)
- **Room Isolation** — room code always sourced from `$_SESSION`, never from client input on message send

---

## 🔥 Ephemeral Room Lifecycle

```
Create Room  →  12-char code generated (crypto-random)
                Room stored as rooms/{CODE}.json
     ↓
  Chat        →  Messages appended as E2EE ciphertext
                Heartbeat system: each poll updates participant timestamp
     ↓
  Auto-Purge  →  Burn timers: 30s / 1m / 5m / 15m (per-message)
                Room auto-deletes when all participants inactive >15s
                Hard expiry: 24 hours from creation
     ↓
  Disconnect  →  Session destroyed, room file deleted immediately
                No data persists. No database. No logs.
```

- **No database** — all data lives in temporary JSON files under `rooms/`
- **Burn timers** — configurable per message (30s, 1m, 5m, 15m)
- **Heartbeat cleanup** — rooms with no active participants for 15 seconds are auto-deleted
- **24-hour hard expiry** — rooms older than 24 hours are purged on next fetch
- **Manual burn** — users can delete individual messages or purge the entire room instantly
- **Session-bound** — refreshing or closing the tab destroys the session and wipes local crypto keys

---

## 🛠️ Tech Stack

| Layer      | Technology                                              |
| :--------- | :------------------------------------------------------ |
| Frontend   | Vanilla JavaScript, Tailwind CSS (CDN), Inter + IBM Plex Mono fonts |
| Crypto     | Web Crypto API (`crypto.subtle`) — AES-256-GCM, PBKDF2, HKDF |
| Backend    | PHP 8.3 (session management, room CRUD, message relay)  |
| Storage    | Flat JSON files (`rooms/*.json`) — no database           |
| Server     | Apache with `mod_rewrite` (clean URLs)                  |
| Deployment | Docker (PHP 8.3-Apache image), Render.com               |
| Design     | Dark-on-black aesthetic, ambient glow system, glassmorphism panels |

---

## 🚀 Local Development

### Prerequisites

- PHP 8.3+
- Apache with `mod_rewrite` enabled
- Or use [Laragon](https://laragon.org/) / XAMPP / Docker

### Run Locally (Laragon)

1. Clone into your `www` directory:
   ```bash
   git clone https://github.com/dwijsys/Nulvexor.git
   ```
2. Ensure `rooms/` and `sessions/` directories exist and are writable.
3. Access at `http://nulvexor.test` (Laragon) or `http://localhost/Nulvexor`.

### Run with Docker

```bash
docker build -t nulvexor .
docker run -p 10000:10000 nulvexor
```

Access at `http://localhost:10000`.

### Deploy to Render

The `render.yaml` and `Dockerfile` are pre-configured. Connect the GitHub repo to Render and it will auto-deploy as a Docker web service on port 10000.

---

## 📂 API Endpoints

All endpoints use clean URLs (`.php` extension stripped via `.htaccess`).

| Endpoint              | Method | Description                              |
| :-------------------- | :----- | :--------------------------------------- |
| `/`                   | GET    | Landing page — create or join a room     |
| `/room`               | GET    | Chat room (requires active session)      |
| `/guide`              | GET    | User guide & documentation               |
| `/create_room`        | POST   | Create a new room (CSRF + rate limited)  |
| `/join_room`          | POST   | Join existing room by code (CSRF + rate limited) |
| `/send_message`       | POST   | Send E2EE ciphertext to room             |
| `/fetch_messages`     | GET    | Poll messages + heartbeat + burn cleanup |
| `/destroy_room`       | POST   | Destroy room & session (empty rooms only)|
| `/disconnect-room`    | POST   | Immediate room deletion + session kill   |
| `/verify_decrypt_code`| POST   | Verify a per-message decrypt code        |

---

## 📝 License

ISC

---

© 2026 CLOAKFORT PROTOCOL
[www.nulvexor.co.in](https://www.nulvexor.co.in)
