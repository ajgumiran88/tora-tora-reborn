# WP Pusher — read this first

This repository is a **WordPress theme**, not a plugin.

Installing it under **WP Pusher → Install Plugin** causes:

> The plugin does not have a valid header.

## Correct settings (Install Theme)

| Field | Value |
| --- | --- |
| Repository host | GitHub |
| Theme repository | `ajgumiran88/tora-tora-reborn` |
| Branch | `main` |
| **Repository subdirectory** | **`tora-tora`** |
| Link installed theme | off (unless folder on server is exactly `tora-tora-reborn`) |
| Push-to-Deploy | optional |

Then click **Install theme** and activate **Tora Tora**.

## If you already installed as a plugin (broken)

1. WP Admin → **Plugins** — delete **tora-tora-reborn** if it appears (do not activate).
2. Via SFTP/File Manager, delete `wp-content/plugins/tora-tora-reborn/` if it exists.
3. Follow **Install Theme** steps above, **or** upload [tora-tora.zip from Releases](https://github.com/ajgumiran88/tora-tora-reborn/releases/latest).

## After update

**Purge SG Cache** from the WordPress admin bar.

View page source — you should see `<!-- tora-tora:1.1.3 safe-head=1 -->` in `<head>`.
