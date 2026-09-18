# Figma-Aligned Design Refactor & Client Feedback Implementation

Refactor the **Tora Tora** WordPress theme across the **Home**, **About**, **Menu**, **Delivery**, **Gallery**, **Careers**, and **Contact** panels to strictly match the approved [Figma Design (node-id 12-1816)](https://www.figma.com/design/xax25PRsv0H2FcpAhEqsGL/TORA-TORA-Website?node-id=12-1816) and address all client comments.

---

## User Review Required

> [!IMPORTANT]
> **Hosting Platform Direct Import Explanation**:
> The user asked: *"Can’t this be directly imported on the hosting platform you’re currently using to save time? As we can’t change any element of the design as this is approved."*
> **Technical Answer**: Figma is a visual vector design tool, whereas WordPress on SiteGround is a dynamic server-side PHP/MySQL application. Standard hosting platforms cannot natively "import" a Figma canvas directly into a production website. While third-party "Figma to WordPress" automated exporters exist, they generate brittle, bloated code that breaks dynamic custom post types (food menu, job listings, customizer settings, lightbox modals, responsive breakpoints, and staging safeguards). The industry standard, reliable method is coding the approved design directly into the theme files.

> [!NOTE]
> **Delivery Logos Exception**:
> Per the client instruction (*"IT SHOULD BE AS IS EXECPT FOR THE IMAGE OF DELIVERY LOGO"*), the approved delivery platform logos (`delivery-talabat.svg`, `delivery-noon.png`, and `delivery-deliveroo.svg`) packaged in the theme will be preserved, while the delivery layout, subheading scale, zone boxes, and card spacing will be refactored to Figma specifications.

---

## Proposed Changes

### 1. Home Page Panel

- **Remove Ramen Image & Cutout Mask**:
  - Ensure no ramen bowl or chopsticks imagery is rendered.
  - In [main.css](file:///Users/arneljayvgumiran/Projects/tora-tora-reborn/tora-tora/assets/css/main.css), remove the circular concave cutout mask (`-webkit-mask-image: radial-gradient(...)`) on `.home-pattern::before`. The blue tiger speckle pattern on the right column will form a crisp, straight vertical split against the white headline column, with the white gutter on the far right for the hamburger navigation toggle.

---

### 2. About Page Panel (`#about`)

- **Design Layout Alignment (Figma node `12-1816`)**:
  - **Title**: Break "ABOUT" and "TORA TORA" onto two distinct lines with bold display geometry (`#about-title`).
  - **Sentence Case Typography**: In [main.css](file:///Users/arneljayvgumiran/Projects/tora-tora-reborn/tora-tora/assets/css/main.css), remove `text-transform: uppercase` from `.story-copy .entry-content` so the About story reads in natural sentence case as designed in Figma.
  - **Bold & Italic Emphasis**: Adjust the base body font weight to `400` so `<strong>` (weight 700) and `<em>` (italic) stand out with clear visual hierarchy:
    - *'tiger'* in italics (`<em>'tiger'</em>`)
    - **courage, strength and indomitable spirit** in bold (`<strong>courage, strength and indomitable spirit</strong>`)
    - *protection and good fortune* in italics (`<em>protection and good fortune</em>`)
    - **bold flavours and vibrant dining experiences** in bold (`<strong>bold flavours and vibrant dining experiences</strong>`)
    - **Tora Tora** in bold (`<strong>Tora Tora</strong>`)
    - **Japanese culture to Dubai** in bold (`<strong>Japanese culture to Dubai</strong>`)
    - **dynamic and powerful as the tiger itself** in bold (`<strong>dynamic and powerful as the tiger itself</strong>`)
    - *tradition with contemporary flair* in italics (`<em>tradition with contemporary flair</em>`)
  - **Decorative Accents**:
    - Add top-right corner blue accent arc matching the Figma frame.
    - Position the pattern disc and tiger mark disc with exact Figma offset coordinates.
    - Replace the bottom static speckle bar with the repeating `TORA TORA` typography ticker.
  - **Content Upgrade Migration**: Add a content migration function in [default-content.php](file:///Users/arneljayvgumiran/Projects/tora-tora-reborn/tora-tora/inc/default-content.php) to automatically update the About page content in the database on theme activation/update.

---

### 3. Menu Panel (`#menu`)

- **Right Border Fix & Full Height Coverage**:
  - Remove the solid blue pseudo-element (`.menu-rail-right::after { background: var(--tora-blue); }`) that was obscuring the right edge of the pattern.
  - Refactor `.menu-rail` and `.menu-layout` in [main.css](file:///Users/arneljayvgumiran/Projects/tora-tora-reborn/tora-tora/assets/css/main.css) so the patterned vertical rail seamlessly covers the full height of the panel across all screen sizes and persists smoothly throughout scrolling.

---

### 4. Delivery Panel (`#delivery`)

- **Subheading Sizing & Hierarchy**:
  - Reduce the font size, letter-spacing, and line-height of the delivery copy (`.delivery-copy .entry-content`) so it acts as a refined, restrained subheading beneath `ORDER DELIVERY`.
- **Card Spacing**:
  - In `.delivery-card`, increase breathing room between the `"Order now →"` CTA and the descriptive text below it (`.delivery-card p`).
- **Delivery Zone Boxes Structure**:
  - Refactor the delivery zones and delivery hours containers into 3 equal, structured cards/boxes side-by-side matching the Figma layout, with proper internal padding, typography, and border styling.

---

### 5. Gallery Panel (`#gallery`)

- **Geometric Pattern Layout (Not a Collage)**:
  - In [front-page.php](file:///Users/arneljayvgumiran/Projects/tora-tora-reborn/tora-tora/front-page.php) and [main.css](file:///Users/arneljayvgumiran/Projects/tora-tora-reborn/tora-tora/assets/css/main.css), rebuild the gallery mosaic grid into the exact 4-column x 4-row geometric pattern from the Figma design:
    - **Row 1**: Item 1 (col 1), Item 2 (col 2), *empty* (col 3), Item 3 (col 4)
    - **Row 2**: *empty* (col 1), *empty* (col 2), Item 4 (col 3), Item 5 (col 4)
    - **Row 3**: Item 6 (wide card spanning cols 1 & 2), Item 7 (col 3), *empty* (col 4)
    - **Row 4**: Item 8 (col 1), Item 9 (col 2), Item 10 (col 3), Item 11 (col 4)
  - Ensure all photo containers maintain consistent aspect ratios, white backgrounds, and lightbox preview triggers.

---

### 6. Careers Panel (`#careers`)

- **Title Formatting**:
  - Update `#careers-title` so `"JOIN"` sits on the first line and `"THE TEAM"` is locked together on the second line:
    `<span>JOIN</span><br><span class="careers-team-line">THE TEAM</span>`
    with `white-space: nowrap;` on `.careers-team-line`.
- **Separator Bullet Point**:
  - In [jobs.php](file:///Users/arneljayvgumiran/Projects/tora-tora-reborn/tora-tora/inc/jobs.php) and [front-page.php](file:///Users/arneljayvgumiran/Projects/tora-tora-reborn/tora-tora/front-page.php), normalize any em dashes (`—`), en dashes (`–`), or hyphens (`-`) between job types and locations into the Figma-approved bullet point separator (`•`), styled via `.careers-job-bullet`.

---

### 7. Contact Panel (`#contact`)

- **Tora Tora Logo Adjustment**:
  - Adjust `.contact-logo` sizing, aspect ratio, and alignment in the top right header to align cleanly with the right column content as shown in Figma.
- **Locations in Two Lines**:
  - Refactor `tora_tora_format_address_lines()` in [setup.php](file:///Users/arneljayvgumiran/Projects/tora-tora-reborn/tora-tora/inc/setup.php) and the markup in [front-page.php](file:///Users/arneljayvgumiran/Projects/tora-tora-reborn/tora-tora/front-page.php) so the address is cleanly rendered on exactly two lines across desktop and mobile:
    - Line 1: `First Avenue Mall, Jumeira,`
    - Line 2: `Dubai, UAE`
- **Grid Spacing & Hierarchy**:
  - Calibrate the gap between the left column (Location, Get in touch) and right column (Opening hours, Follow us) and map embed to mirror the Figma spacing.

---

### 8. Verification & Test Suite Updates

- Update [tests/run.php](file:///Users/arneljayvgumiran/Projects/tora-tora-reborn/tests/run.php) to validate:
  - Home pattern clean edge (no concave mask)
  - About sentence case copy and emphasis
  - Menu rail full coverage without solid overlay
  - Delivery card CTA spacing and zone boxes grid
  - Gallery 4x4 geometric pattern tiles
  - Careers two-line title with "THE TEAM" locked and bullet separator
  - Contact two-line location and logo styling
- Package the updated theme into `dist/tora-tora.zip` and `dist/tora-tora-reborn.zip`.

---

## Verification Plan

### Automated Tests
- Run PHP test suite:
  ```bash
  php tests/run.php
  ```
- Verify CSS syntax and PHP syntax:
  ```bash
  php -l tora-tora/front-page.php
  php -l tora-tora/functions.php
  php -l tora-tora/inc/setup.php
  php -l tora-tora/inc/jobs.php
  php -l tora-tora/inc/default-content.php
  ```

### Manual & Visual Verification
- Verify responsive layout at 375px (mobile), 768px (tablet), 1024px (desktop), and 1440px (wide desktop).
- Inspect each section against the Figma design thumbnails and node `12-1816`.
