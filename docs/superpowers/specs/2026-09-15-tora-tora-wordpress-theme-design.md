# Tora Tora WordPress Theme — Approved Design

## Purpose

Create a ZIP-installable WordPress theme for the Tora Tora restaurant website. The build is a content website only: it does not provide booking, ordering, payment, or e-commerce.

## Sources of truth

- **Website layouts:** [TORA TORA Website (Figma)](https://www.figma.com/design/xax25PRsv0H2FcpAhEqsGL/TORA-TORA-Website?node-id=0-1)
- **Brand system:** [2. BRAND GUIDELINE (Dropbox)](https://www.dropbox.com/scl/fo/7jo8j6t8ilp129yviz41g/AI1_nKEmlXHR8kUbjlmO2rI?rlkey=3fx4h06py2z5yvbvtzlfdv0k1) — Colour Palette, Typography (Raleway), Pattern, Interior
- **Extraction notes:** [`docs/design-guides.md`](../design-guides.md)

## Experience

- Preserve the supplied Tora Tora logo, official speckle/tiger pattern, royal-blue (`#0500F5`) / white (`#FFFFFF`) palette with cream light panels, Raleway typography, immersive full-screen panels, overlay navigation, tabbed menu, delivery partner cards, and gallery lightbox.
- Use the approved single-page panel flow for Home, About (Story), Menu, Delivery, Gallery, Contact, and Careers, with URL hashes and browser back/forward support.
- Menu categories follow Figma tabs: Breakfast, Appetizers, Draft Food Menu, Desserts, Beverage (`#menu` / `#menu-{slug}`).
- Delivery panel links out to Talabat, Noon, and Deliveroo (Customizer URLs + logos); no in-theme checkout.
- Make the layout responsive, keyboard usable, focus-visible, reduced-motion friendly, and usable at 375, 768, 1024, and 1440 pixels.
- Package all essential brand imagery in the theme. Blank food/interior areas may use tasteful branded placeholders until final photography is supplied.

## WordPress editing model

- Use native WordPress and Gutenberg; require no premium plugins or page builder.
- Make Home, Story, Delivery, Gallery, Contact, and Careers copy editable through WordPress pages.
- Provide a `Food Menu` / menu item content type with title, category, description, price, featured image, availability, and display order.
- Provide menu categories through a hierarchical `Menu Categories` taxonomy. The public menu groups available items by category and updates automatically.
- Provide Customizer settings for contact details, social links, delivery platform URLs/logos, zones, hours, gallery images, footer text, and staging mode.
- Seed starter pages, categories, and menu items once on theme activation without overwriting later editor changes.

## Staging safeguards

- Enable staging mode by default.
- Display: `STAGING PREVIEW — This website is for review only.`
- Apply WordPress `noindex, nofollow` robots directives and an `X-Robots-Tag` header while staging mode is enabled.
- Allow an administrator to disable staging mode before launch.
- Do not deploy or publish the live website until client approval.

## Delivery

- Keep theme files at the repository root so WP Pusher installs as `tora-tora-reborn` with an empty subdirectory field.
- Deliver `dist/tora-tora-reborn.zip` with `tora-tora-reborn/` as the ZIP root.
- Document brand and Figma sources in the repository README and `docs/design-guides.md`.
