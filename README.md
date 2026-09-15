# Tora Tora WordPress Theme (Reborn)

ZIP-installable, staging-safe WordPress theme for the **Tora Tora** Dubai restaurant site. Content website only — no booking, ordering checkout, payments, or e-commerce. Delivery CTAs are outbound links to partner platforms.

**Installable package:** [`dist/tora-tora.zip`](dist/tora-tora.zip)  
**Theme source:** [`wp-content/themes/tora-tora/`](wp-content/themes/tora-tora/)  
**Theme version:** 1.1.0

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
| Typeface | **Raleway** (Google Fonts), weights used for UI + display | `style.css` / `main.css` |
| Speckle / tiger pattern | Official pattern asset (WebP + PNG fallbacks, cover sizing) | `assets/images/tora-tora-pattern.*` |
| Logo | Packaged logo + transparent tiger mark | `assets/images/tora-tora-logo.png`, `tiger-mark.png` |

---

## Site experience (Figma-aligned)

Single immersive shell with full-viewport panels, hash URLs, and browser back/forward:

| Panel | Hash | Notes |
| --- | --- | --- |
| Home | `#home` | Brand-first hero, pattern field, View Menu CTA |
| About Tora Tora | `#story` | Editable page copy + featured image |
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

## Install

1. WordPress Admin → **Appearance → Themes → Add New → Upload Theme**.
2. Upload `dist/tora-tora.zip`, install, activate **Tora Tora**.
3. Edit Pages for copy; set Featured Images on Home / About / Contact panels as needed.
4. Manage dishes under **Food Menu**; categories follow Figma tabs.
5. Configure **Appearance → Customize → Tora Tora details**.

Requires WordPress 6.4+, PHP 8.0+.

---

## Repo layout

```
dist/tora-tora.zip              # Installable theme ZIP (root folder: tora-tora/)
docs/                           # Design spec, plan, brand guide notes
tests/run.php                   # Static acceptance checks
wp-content/themes/tora-tora/    # Theme source
```

Local smoke WordPress core, QA renders, and Figma dumps live under `work/` and are **gitignored** (not pushed).

---

## Verification

```bash
php tests/run.php
```

Smoke locally by installing the ZIP into any WP 6.4+ instance (or syncing `wp-content/themes/tora-tora` into a local install). Keep staging mode on for review.

---

## Constraints & placeholders

- First-version deadline and review-before-launch constraints from client brief.
- Food / interior photography may remain tasteful branded placeholders until final assets are supplied.
- Delivery is **outbound links only** (Talabat, Noon, Deliveroo) — not in-theme checkout.
