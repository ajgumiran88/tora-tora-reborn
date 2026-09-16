# Tora Tora WordPress Theme (Reborn)

ZIP-installable, staging-safe WordPress theme for the **Tora Tora** Dubai restaurant site. Content website only — no booking, ordering checkout, payments, or e-commerce. Delivery CTAs are outbound links to partner platforms.

**Theme files live at the repository root** (`style.css`, `functions.php`, …) so **WP Pusher** can install them as `tora-tora-reborn`.  
**WordPress Admin ZIP (recommended):** [`dist/tora-tora.zip`](dist/tora-tora.zip) — root folder `tora-tora/`  
**Download:** [Release v1.1.0 → tora-tora.zip](https://github.com/ajgumiran88/tora-tora-reborn/releases/download/v1.1.0/tora-tora.zip)  
**Theme version:** 1.1.0

---

## WP Pusher (staging3.toratora.ae)

Use these exact settings on **WP Pusher → Install Theme**:

| Field | Value |
| --- | --- |
| Repository host | GitHub |
| Theme repository | `ajgumiran88/tora-tora-reborn` |
| Repository branch | `main` |
| Repository subdirectory | **leave blank** |
| Repository is private | only if the GitHub repo is private (needs WP Pusher license) |
| Push-to-Deploy | optional (on for auto-update) |
| Link installed theme | **off** on first install |

Then click **Install theme** and activate **Tora Tora**.

### Why the previous install failed

WP Pusher always places the theme in `wp-content/themes/{repository-name}/` → `tora-tora-reborn`.  
“Link installed theme” requires that folder to already exist with the **same name as the repository**. The theme used to live under `wp-content/themes/tora-tora`, so activation of `tora-tora-reborn` failed with “The requested theme does not exist.”

The theme is now at the **repo root**. Leave subdirectory empty and do not use “Link installed theme” unless a folder named `tora-tora-reborn` is already present.

If a broken install remains on the server, delete `wp-content/themes/tora-tora-reborn` (and any empty `tora-tora` leftover) via SFTP/File Manager, then install again with the settings above.

---

## Sources of truth (design)

| Source | Role | Link |
| --- | --- | --- |
| **Figma — TORA TORA Website** | Approved page layouts, panel flow, Menu tabs, Order & Delivery, overlay nav, gallery, contact | [Open Figma](https://www.figma.com/design/xax25PRsv0H2FcpAhEqsGL/TORA-TORA-Website?node-id=0-1) |
| **Brand guidelines (Dropbox)** | Official brand system: Colour Palette, Typography (Raleway), Pattern, Interior | [2. BRAND GUIDELINE folder](https://www.dropbox.com/scl/fo/7jo8j6t8ilp129yviz41g/AI1_nKEmlXHR8kUbjlmO2rI?rlkey=3fx4h06py2z5yvbvtzlfdv0k1) |

Full token and IA notes: [`docs/superpowers/specs/2026-09-15-tora-tora-wordpress-theme-design.md`](docs/superpowers/specs/2026-09-15-tora-tora-wordpress-theme-design.md)  
Brand extraction summary: [`docs/design-guides.md`](docs/design-guides.md)

### Brand tokens applied in the theme

| Token | Value | Where |
| --- | --- | --- |
| Primary blue | `#0500F5` | `theme.json`, CSS `--tora-blue` |
| White | `#FFFFFF` | `theme.json`, CSS `--tora-white` |
| Supporting cream | `#F4ECE7` / `#E8D9D1` | Light panels (About, Contact, etc.) |
| Typeface | **Raleway** (Google Fonts), weights used for UI + display | `style.css` / `assets/css/main.css` |
| Speckle / tiger pattern | Official pattern asset (WebP + PNG fallbacks, cover sizing) | `assets/images/tora-tora-pattern.*` |
| Logo | Packaged logo + transparent tiger mark | `assets/images/tora-tora-logo.png`, `tiger-mark.png` |

---

## Site experience (Figma-aligned)

Single immersive shell with full-viewport panels, hash URLs, and browser back/forward:

| Panel | Hash | Notes |
| --- | --- | --- |
| Home | `#home` | Brand-first hero, pattern field, View Menu CTA |
| About Tora Tora | `#story` / `#about` | Editable page copy + featured image |
| Menu | `#menu` / `#menu-{slug}` | Tabbed categories (Breakfast, Appetizers, Draft Food Menu, Desserts, Beverage) |
| Delivery | `#delivery` | Talabat / Noon / Deliveroo cards + zones/hours (Customizer) |
| Gallery | `#gallery` | Lightbox gallery; images Customizer-editable |
| Careers | `#careers` | Editable page |
| Contact | `#contact` | Contact details from Customizer |

Overlay navigation matches Figma labels: Home · About Tora Tora · Menu · Delivery · Gallery · Careers · Contact.

---

## WordPress editing model

- Native WordPress + Gutenberg only — **no** premium plugins or page builders.
- Editable pages: Home, Story (About), Delivery, Gallery, Contact, Careers (seeded on first activation).
- CPT **Food Menu** + hierarchical **Menu Categories** taxonomy; public menu groups available items by category.
- **Customizer → Tora Tora details:** contact, social, delivery platform URLs/logos, zones, hours, gallery images, footer, staging mode.
- Starter content seeds once; later editor changes are not overwritten.

---

## Staging safeguards (default on)

- Banner: `STAGING PREVIEW — This website is for review only.`
- `noindex, nofollow` + `X-Robots-Tag` while staging is enabled.
- Disable in Customizer only after launch approval. **Do not take the site live** until client sign-off.

---

## Manual ZIP install (easiest)

1. Download [tora-tora.zip](https://github.com/ajgumiran88/tora-tora-reborn/releases/download/v1.1.0/tora-tora.zip).
2. WordPress Admin → **Appearance → Themes → Add New → Upload Theme**.
3. Choose `tora-tora.zip` → **Install Now** → **Activate**.
4. Edit Pages for copy; set Featured Images on Home / About / Contact panels as needed.
5. Manage dishes under **Food Menu**; categories follow Figma tabs.
6. Configure **Appearance → Customize → Tora Tora details**.

Requires WordPress 6.4+, PHP 8.0+. The ZIP contains a single folder `tora-tora/` with `style.css` inside.

---

## Repo layout

```
style.css, functions.php, …   # Theme root (WP Pusher–ready)
assets/, inc/, template-parts/
dist/tora-tora-reborn.zip     # Manual install ZIP (root folder: tora-tora-reborn/)
docs/                         # Design spec, plan, brand guide notes
tests/run.php                 # Static acceptance checks
README.md                     # This file (repo)
README.txt                    # WordPress theme readme
```

Local smoke WordPress core, QA renders, and Figma dumps live under `work/` and are **gitignored** (not pushed).

---

## Verification

```bash
php tests/run.php
```

Keep staging mode on for review.
