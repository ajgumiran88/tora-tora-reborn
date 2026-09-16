# Tora Tora — Design guides & brand extraction

This document records the **external design sources** used to build the WordPress theme and the tokens extracted into code. Prefer these links over ad-hoc colour/type choices.

---

## 1. Website UI (Figma)

**File:** [TORA TORA Website](https://www.figma.com/design/xax25PRsv0H2FcpAhEqsGL/TORA-TORA-Website?node-id=0-1)

| Screen / system | Theme mapping |
| --- | --- |
| Full-bleed home with logo + pattern | `#home` panel, `.home-pattern`, packaged logo |
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
| **Colour Palette** | Primary **Tora Blue** `#0500F5`, **White** `#FFFFFF` | `theme.json` palette; CSS `--tora-blue` / `--tora-white`; blue and light (cream) panels |
| **Typography** | **Raleway** as brand sans; strong display weights for headlines | Google Fonts Raleway; `font-weight: 800` headings; uppercase display treatment |
| **Pattern** | Official tiger / speckle pattern | `assets/images/tora-tora-pattern.webp` (+ PNG/JPG fallbacks); CSS `image-set` + cover sizing for retina |
| **Interior** | Atmosphere / photography direction | Gallery + panel imagery may stay placeholder until final shoots |

Supporting cream surfaces used for light panels (`#F4ECE7`, `#E8D9D1`) sit alongside the official blue/white pair so Figma light screens remain readable without inventing a second brand blue.

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
