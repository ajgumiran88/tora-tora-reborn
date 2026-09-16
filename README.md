# Tora Tora WordPress Theme (Reborn)

ZIP-installable, staging-safe WordPress theme for the **Tora Tora** Dubai restaurant site.

**Repository:** https://github.com/ajgumiran88/tora-tora-reborn  
**Theme version:** 1.1.3  
**Theme source:** [`tora-tora/`](tora-tora/)  
**Install ZIP:** [tora-tora.zip (latest release)](https://github.com/ajgumiran88/tora-tora-reborn/releases/latest/download/tora-tora.zip)

---

## Quick install (WordPress Admin — recommended)

1. Download [tora-tora.zip](https://github.com/ajgumiran88/tora-tora-reborn/releases/latest/download/tora-tora.zip).
2. **Appearance → Themes → Add New → Upload Theme** → install → activate.
3. **Purge SG Cache** (admin bar).
4. View source — confirm `<!-- tora-tora:1.1.3 safe-head=1 -->`.

---

## WP Pusher

**Use Install Theme — not Install Plugin.**  
See **[WPPUSHER.md](WPPUSHER.md)** for full steps.

| Field | Value |
| --- | --- |
| Theme repository | `ajgumiran88/tora-tora-reborn` |
| Branch | `main` |
| **Repository subdirectory** | **`tora-tora`** |

Wrong: Install Plugin → *“The plugin does not have a valid header.”*

---

## Design sources

| Source | Link |
| --- | --- |
| Figma website | [TORA TORA Website](https://www.figma.com/design/xax25PRsv0H2FcpAhEqsGL/TORA-TORA-Website?node-id=0-1) |
| Brand guidelines | [Dropbox — 2. BRAND GUIDELINE](https://www.dropbox.com/scl/fo/7jo8j6t8ilp129yviz41g/AI1_nKEmlXHR8kUbjlmO2rI?rlkey=3fx4h06py2z5yvbvtzlfdv0k1) |

Details: [`docs/design-guides.md`](docs/design-guides.md)

---

## Staging (default on)

- Review banner + `noindex`
- **Safe head** bypasses `wp_head` fatals on SiteGround + Rank Math while staging is enabled
- Turn off in **Customizer → Tora Tora details** before launch

---

## Repo layout

```
tora-tora/          # Theme files (style.css, functions.php, assets/, inc/)
dist/               # Install ZIPs
docs/               # Design spec + brand guides
tests/run.php       # php tests/run.php
WPPUSHER.md         # WP Pusher settings (read before using)
```

`work/` is gitignored (local smoke WordPress).
