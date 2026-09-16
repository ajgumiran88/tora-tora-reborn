# Careers + WP Job Manager

## Goal
Fix `#careers` so polluted WP page HTML no longer dumps raw CSS/`<br>`, and live Job Manager listings drive the openings card with Apply → single job application flow.

## Files
- `tora-tora/inc/jobs.php` (new) — listing query, title/content sanitizers
- `tora-tora/functions.php` — require jobs.php
- `tora-tora/front-page.php` — careers panel markup
- `tora-tora/single-job_listing.php` (new) — branded apply page
- `tora-tora/assets/css/main.css` — job list + single styles
- `tora-tora/inc/default-content.php` — clean careers defaults
- `tests/run.php` — contract checks

## Behavior
1. Ignore polluted careers page body (CSS, `[jobs]`, Sakuri leftovers); use sanitized content or theme fallback.
2. Query published unfilled `job_listing` posts.
3. Listings link to single job (WPJM apply). Mailto CV remains secondary.
4. Empty state: helpful copy + Email Your CV.
