# Tora Tora WordPress Theme (Reborn)

ZIP-installable, staging-safe WordPress theme for the **Tora Tora** Dubai restaurant site. Content website only — no booking, ordering checkout, payments, or e-commerce. Delivery CTAs are outbound links to partner platforms.

**Repository:** https://github.com/ajgumiran88/tora-tora-reborn  
**Theme version:** 1.1.2  
**Latest install ZIP:** [tora-tora.zip (v1.1.2)](https://github.com/ajgumiran88/tora-tora-reborn/releases/download/v1.1.2/tora-tora.zip)  
**Releases:** https://github.com/ajgumiran88/tora-tora-reborn/releases

---

## Quick install (WordPress Admin — recommended)

1. Download [tora-tora.zip v1.1.2](https://github.com/ajgumiran88/tora-tora-reborn/releases/download/v1.1.2/tora-tora.zip).
2. WP Admin → **Appearance → Themes → Add New → Upload Theme**.
3. Choose `tora-tora.zip` → **Install Now** → **Activate** (replace existing if prompted).
4. **Purge SG Cache** from the admin bar (SiteGround).
5. View page source — confirm `<!-- tora-tora:1.1.2 safe-head=1 -->` appears in `<head>`.

Requires WordPress 6.4+, PHP 8.0+. ZIP root folder: `tora-tora/` (contains `style.css`).

---

## WP Pusher

Theme files live at the **repository root** (`style.css`, `functions.php`, …) so WP Pusher installs as `tora-tora-reborn`.

| Field | Value |
| --- | --- |
| Repository host | GitHub |
| Theme repository | `ajgumiran88/tora-tora-reborn` |
| Branch | `main` |
| Repository subdirectory | **leave blank** |
| Push-to-Deploy | optional |
| Link installed theme | **off** on first install |

After push, **Purge SG Cache**. For manual upload instead, use the ZIP above (`tora-tora/` folder name).

---

## Staging safeguards (default on)

- Banner: `STAGING PREVIEW — This website is for review only.`
- `noindex, nofollow` + `X-Robots-Tag` while staging is enabled.
- **Safe head mode (v1.1.2+):** bypasses `wp_head` / `wp_footer` plugin hooks while staging is on, preventing blank pages on SiteGround + Rank Math stacks.
- Disable staging in **Appearance → Customize → Tora Tora details** only after launch approval.

---

## Sources of truth (design)

| Source | Role | Link |
| --- | --- | --- |
| **Figma — TORA TORA Website** | Approved layouts, Menu tabs, Delivery, overlay nav, gallery | [Open Figma](https://www.figma.com/design/xax25PRsv0H2FcpAhEqsGL/TORA-TORA-Website?node-id=0-1) |
| **Brand guidelines (Dropbox)** | Colour Palette, Typography (Raleway), Pattern, Interior | [2. BRAND GUIDELINE](https://www.dropbox.com/scl/fo/7jo8j6t8ilp129yviz41g/AI1_nKEmlXHR8kUbjlmO2rI?rlkey=3fx4h06py2z5yvbvtzlfdv0k1) |

- Design spec: [`docs/superpowers/specs/2026-09-15-tora-tora-wordpress-theme-design.md`](docs/superpowers/specs/2026-09-15-tora-tora-wordpress-theme-design.md)
- Brand extraction: [`docs/design-guides.md`](docs/design-guides.md)

### Brand tokens

| Token | Value | Where |
| --- | --- | --- |
| Primary blue | `#0500F5` | `theme.json`, CSS `--tora-blue` |
| White | `#FFFFFF` | `theme.json`, CSS `--tora-white` |
| Cream surfaces | `#F4ECE7` / `#E8D9D1` | Light panels |
| Typeface | **Raleway** | Google Fonts / `assets/css/main.css` |
| Pattern | WebP + PNG fallbacks | `assets/images/tora-tora-pattern.*` |

---

## Site experience

| Panel | Hash | Notes |
| --- | --- | --- |
| Home | `#home` | Hero, pattern, View Menu CTA |
| About | `#about` | Editable page + featured image |
| Menu | `#menu` / `#menu-{slug}` | Breakfast, Appetizers, Draft Food Menu, Desserts, Beverage |
| Delivery | `#delivery` | Talabat / Noon / Deliveroo |
| Gallery | `#gallery` | Lightbox |
| Careers | `#careers` | Editable page |
| Contact | `#contact` | Customizer details |

---

## WordPress editing

- Native WordPress + Gutenberg only — no page builders.
- **Food Menu** CPT + **Menu Categories** taxonomy.
- **Customizer → Tora Tora details:** contact, delivery URLs/logos, zones, hours, gallery, footer, staging mode.
- Starter content seeds once on activation.

---

## Repo layout

```
style.css, functions.php, …   # Theme root (WP Pusher–ready)
assets/, inc/, template-parts/
dist/tora-tora.zip              # Admin upload ZIP (folder: tora-tora/)
dist/tora-tora-reborn.zip       # Same theme (folder: tora-tora-reborn/)
docs/                           # Design spec + brand guides
tests/run.php                   # Static acceptance checks
```

`work/` is gitignored (local smoke WordPress, QA renders).

---

## Verification

```bash
php tests/run.php
```
