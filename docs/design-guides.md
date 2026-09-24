# Tora Tora — Design guides & brand extraction

This document records the **external design sources** used to build the WordPress theme and the tokens extracted into code. Prefer these links over ad-hoc colour/type choices.

---

## 1. Website UI (Figma)

**File:** [TORA TORA Website](https://www.figma.com/design/xax25PRsv0H2FcpAhEqsGL/TORA-TORA-Website?node-id=0-1)

| Screen / system | Theme mapping |
| --- | --- |
| Home split: white headline column + speckle column (no ramen hero) | `#home` panel, `.home-split`, `.home-pattern`, packaged logo |
| Overlay nav with X close | `.site-nav` / `.nav-overlay` |
| About / story | `#story` |
| Menu with category tabs | `#menu` + `#menu-{slug}`; CPT + taxonomy |
| Order & Delivery (Talabat / Noon / Deliveroo) | `#delivery` panel + Customizer URLs/logos |
| Gallery | `#gallery` + lightbox |
| Careers / Contact | `#careers`, `#contact` |
| Hash navigation + history | `assets/js/site.js` |

Prototype reference (same file):  
https://www.figma.com/proto/xax25PRsv0H2FcpAhEqsGL/TORA-TORA-Website

---

## 2. Brand guidelines (Dropbox)

**Folder:** [2. BRAND GUIDELINE](https://www.dropbox.com/scl/fo/7jo8j6t8ilp129yviz41g/AI1_nKEmlXHR8kUbjlmO2rI?rlkey=3fx4h06py2z5yvbvtzlfdv0k1)

Client-supplied brand kit (referenced during planning as the design-guide / “drive” pack). Subfolders used:

| Folder | Extracted guidance | Theme application |
| --- | --- | --- |
| **Colour Palette** | Brand Book lists exactly two: **Tora Blue** `#0500F5` (R5 G0 B245 / C98 M100 Y0 K4) and **White** `#FFFFFF` (C0 M0 Y0 K0) | `theme.json` palette; CSS `--tora-blue` / `--tora-white`; light panels use **white** (`#FFFFFF`), not cream |
| **Typography** | Brand Book names two faces: **Typeface 01 — ITC Avant Garde Gothic** (geometric display) and **Typeface 02 — Raleway** (versatile multi-weight sans) | Typeface 01 is self-hosted at `assets/fonts/avantgarde-{400,500,600,700}.woff2` and drives every heading (`h1`–`h4`, panel titles, gallery numbers, menu dish names) via `--font-display`. Bold 700 is the heaviest cut supplied, so no Avant Garde text is set above 700, in `main.css`, `theme.json` or `editor.css`. Typeface 02 is self-hosted as a variable font (`assets/fonts/raleway-latin-wght-*.woff2`, weights 200–800) and carries body copy, labels, the overlay nav and menu notes. Both faces are registered in `theme.json`, so the block editor shows them too. Client supplied the Avant Garde files; confirm the Monotype licence covers web embedding before launch. |
| **Pattern** | Official tiger / speckle pattern | `assets/images/tora-tora-pattern.webp` (+ PNG/JPG fallbacks); CSS `image-set` + cover sizing for retina |
| **Interior** | Atmosphere / photography direction | Not available locally yet. The gallery still uses stand-in photos (see the launch checklist) |

Cream (`#F4ECE7`) is retained only for the staging chrome strip. Figma light screens (About, Menu, Delivery, Careers) use solid white. Background tiger watermarks are **not** used on panel surfaces; the About page keeps only the intentional circular tiger graphic in the layout.

---

## 3. Code anchors

| Concern | Path |
| --- | --- |
| Design tokens (CSS) | `tora-tora/assets/css/main.css` (`:root`) |
| Editor / block palette | `tora-tora/theme.json` |
| Panel markup | `tora-tora/front-page.php` |
| Hash / overlay / lightbox | `tora-tora/assets/js/site.js` |
| Staging / noindex | `tora-tora/inc/staging.php` |
| Delivery + contact Customizer | `tora-tora/inc/customizer.php` |
| Starter menu categories | `tora-tora/inc/default-content.php` |

---

## 4. Launch checklist

The client's comments asked that gallery photos and contact details be accurate before launch. None of the items below has been confirmed yet. Keep **Staging mode** on (Customizer → Tora Tora details) until every box is ticked. Staging mode shows the preview banner and sets noindex.

- [ ] **Phone.** The Customizer default `+971 4 000 0000` is a placeholder.
- [ ] **Emails.** `hello@toratora.ae` (contact and careers) and `reserve@toratora.ae` (reservations) are unverified. Confirm each inbox exists and is monitored.
- [ ] **Opening hours.** Contact hours (`08:00 - 23:00`, `08:00 - 00:00`) and delivery hours are starter values.
- [ ] **Instagram and TikTok.** Both point to `@toratora.ae`, which is hard-coded in `inc/setup.php`. Confirm both profiles belong to the restaurant.
- [ ] **Gallery photos.** `gallery-1.jpg` to `gallery-5.jpg` are generic dining-room images, not Tora Tora photography, and the mosaic repeats them across 11 tiles. Upload the restaurant's own photos from the Brand Guideline **Interior** folder through Customizer → Tora Tora details → Gallery image 1–5. Tiles 6–11 reuse images 1–5, so five strong photos are enough.
- [ ] **Chef Gouda story.** The About page's "Chef Gouda's kitchen" section and the Menu intro line are seed copy. They state only that Chef Gouda leads the kitchen and that the menu is made in-house. Replace them with approved copy: edit the section in Pages → About Tora Tora (everything from its first heading down), and the intro line in Customizer → Tora Tora details → Menu intro line.

The address and map pin (First Avenue Mall, Jumeira) are confirmed and stay as they are.

---

## 5. Out of scope (by brief)

- Live production publish before client approval  
- In-theme ordering, booking, payments, or e-commerce plugins  
- Replacing partner delivery platforms with custom checkout  

When brand PDFs or Figma frames change, update this file and re-check tokens in `theme.json` / `main.css` before shipping a new ZIP.
