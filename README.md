# NJ INTERIORS — Immersive 3D Architectural Portfolio (PHP Yii2)

**CRAFTING LUXURY WITH CARE**  
Single-page luxury architectural portfolio application for **NJ INTERIORS** (Established 2016, Bhubaneswar, Odisha, India), led by Creative Director & Proprietor **Nitesh Kumar Jangda**.

---

## 1. Architecture & Technology Stack

- **Backend Framework**: PHP 8.2+ & Yii2 MVC Architecture (`controllers/SiteController.php`, `controllers/ContactController.php`, `models/ContactForm.php`, `assets/AppAsset.php`)
- **Frontend Motion & 3D**:
  - **GSAP + ScrollTrigger** (`web/js/animations.js`) — Hero mask & staggered character reveal, line-by-line typography reveal, parallax imagery, clip-path masks, process timeline scroll progression, and vision zoom.
  - **Lenis Smooth Scroll** (`web/js/main.js`) — Smooth inertial scrolling synchronized with GSAP's ticker.
  - **Three.js** (`web/js/main.js`) — Selective 3D architectural wireframe portals and golden-ratio spatial datum lines in Section 01.
  - **Native 9:16 4K Video Showcase** (`web/js/video.js`) — Preserves the exact `2160x3840` (9:16 portrait) aspect ratio of the supplied company walkthrough film (`Sequence 10_1.MP4` -> `web/videos/nj-interiors-showcase.mp4`) without awkward cropping, paired with an ambient synchronised backdrop and custom controls.

---

## 2. Organised Asset Directory Structure

All asset paths are centralized in `config/params.php` under `$params['assets']` so visuals can be replaced without editing view templates:

```text
web/
├── css/
│   ├── bootstrap.min.css
│   ├── site.css
│   └── animations.css
├── js/
│   ├── bootstrap.bundle.min.js
│   ├── main.js
│   ├── animations.js
│   ├── video.js
│   └── interactions.js
├── images/
│   ├── logo/
│   │   └── nj-monogram.svg
│   ├── founder/
│   │   └── nitesh-kumar-jangda.jpg      (Supplied personal photograph)
│   └── projects/
│       ├── residential/
│       │   ├── living-tv-wall.jpg
│       │   └── luxury-residence-interior.jpg
│       ├── kitchen/
│       │   └── modular-kitchen.jpg
│       ├── bedroom/
│       │   └── master-bedroom-wardrobe.jpg
│       ├── furniture/
│       │   └── custom-joinery-credenza.jpg
│       └── commercial/
│           └── hospitality-reception-lounge.jpg
├── videos/
│   └── nj-interiors-showcase.mp4        (Supplied 2160x3840 company video)
└── docs/
    ├── NJ_Interiors_Company_Portfolio.docx
    └── NJ_Interiors_GST_Certificate.pdf
```

---

## 3. Local Installation & Development Server

1. **Verify PHP 8.2+ & Composer Dependencies**:
   ```powershell
   C:\php-8.5.5\php.exe -v
   ```
2. **Start the Development Server**:
   ```powershell
   C:\php-8.5.5\php.exe -S localhost:8080 -t web
   ```
3. Open `http://localhost:8080` in your browser.

---

## 4. Configuring Live SMTP Email Delivery for the Enquiry Form

The enquiry form (`POST /index.php?r=contact/submit`) is protected by Yii2 CSRF validation, honeypot spam protection, and server-side sanitisation (`models/ContactForm.php`).

- **Default Safe Mode (No SMTP Configured)**:
  - All validated enquiries are saved as `.eml` files in `runtime/mail/` and logged as structured JSON Lines in `runtime/enquiries/enquiries.jsonl`.
  - The user interface transparently informs the visitor that the enquiry has been recorded in the server queue and offers one-click WhatsApp dispatch to `+91 95832 05010`.
- **Enabling Live SMTP to `njinteriorbbs@gmail.com`**:
  - Set the `SMTP_DSN` environment variable on your server (never in frontend code):
    ```bash
    export SMTP_DSN="smtp://njinteriorbbs%40gmail.com:YOUR_APP_PASSWORD@smtp.gmail.com:587"
    ```
  - When `SMTP_DSN` is present, `config/web.php` automatically switches `useFileTransport` to `false` and dispatches live emails directly to `njinteriorbbs@gmail.com`.

---

## 5. Production Deployment Instructions

1. In `web/index.php`, set `YII_DEBUG` to `false` and `YII_ENV` to `'prod'`.
2. Point your Apache/Nginx virtual host `DocumentRoot` to the `web/` directory.
3. Ensure `runtime/` and `web/assets/` are writable by the web server user.
4. Set the `SMTP_DSN` environment variable in your hosting control panel or PHP-FPM pool configuration.
