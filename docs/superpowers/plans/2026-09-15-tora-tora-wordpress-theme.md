# Tora Tora WordPress Theme — Implementation Plan

**Sources:** [Figma website](https://www.figma.com/design/xax25PRsv0H2FcpAhEqsGL/TORA-TORA-Website) · [Dropbox brand guidelines](https://www.dropbox.com/scl/fo/7jo8j6t8ilp129yviz41g/AI1_nKEmlXHR8kUbjlmO2rI?rlkey=3fx4h06py2z5yvbvtzlfdv0k1) · see also [`docs/design-guides.md`](../../design-guides.md)

1. Add static acceptance tests for the theme contract, WordPress registrations, staging safeguards, local assets, accessibility hooks, and package structure.
2. Scaffold the hybrid theme and register theme support, assets, navigation, editor styles, and native content models.
3. Implement the menu item type, menu taxonomy, typed metadata, editor controls, REST exposure, ordering, and starter content.
4. Implement editable page panels, Figma-aligned tabbed Menu, Delivery partner cards, gallery lightbox, overlay navigation, hash history, modal focus management, and reduced-motion behavior.
5. Add Customizer controls and default-on staging notice/noindex behavior.
6. Package Dropbox/Figma brand assets (logo, pattern WebP/PNG, delivery logos) and fallbacks; keep theme at repo root for WP Pusher; validate PHP, JavaScript, accessibility-related markup, local asset references, and ZIP layout.
7. Request an independent code review, address material findings, rerun verification, and produce the installable ZIP.
