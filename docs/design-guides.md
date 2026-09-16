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
| **Typography** | Brand Book names two faces: **Typeface 01 — ITC Avant Garde Gothic** (geometric display) and **Typeface 02 — Raleway** (versatile multi-weight sans) | Typeface 01 is self-hosted at `assets/fonts/avantgarde-{400,500,600,700}.woff2` and drives `h1`–`h4` via `--font-display`; Bold 700 is the heaviest cut supplied, so headings cap at 700. Typeface 02 loads from Google Fonts (Raleway `200;400;500;600;700;800`) and carries body copy, labels and the overlay nav. Client supplied the Avant Garde files; confirm the Monotype licence covers web embedding before launch. |
| **Pattern** | Official tiger / speckle pattern | `assets/images/tora-tora-pattern.webp` (+ PNG/JPG fallbacks); CSS `image-set` + cover sizing for retina |
| **Interior** | Atmosphere / photography direction | Gallery + panel imagery may stay placeholder until final shoots |

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

## 4. Out of scope (by brief)

- Live production publish before client approval  
- In-theme ordering, booking, payments, or e-commerce plugins  
- Replacing partner delivery platforms with custom checkout  

When brand PDFs or Figma frames change, update this file and re-check tokens in `theme.json` / `main.css` before shipping a new ZIP.
