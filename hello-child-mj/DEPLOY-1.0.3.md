# Hello Child MJ 1.0.3 — Deploy & cache

## Zip
- `C:\Users\mjpt1\Desktop\hello-child-mj.zip`
- `C:\Users\mjpt1\Desktop\job\new\modern-portfolio-elementor\hello-child-mj.zip`

## Upload
1. WP Admin → Appearance → Themes → Add New → Upload Theme → choose zip → **Replace current with uploaded**.
2. Or unzip and overwrite `wp-content/themes/hello-child-mj/` via FTP/File Manager (keep folder name exact).
3. Confirm active theme is **Hello Child MJ Portfolio** (parent: Hello Elementor).

## Avatar
- Packaged at `hello-child-mj/assets/img/avatar.png` (transparent PNG).
- HTML uses `get_theme_file_uri` + `?ver=filemtime` — **do not** rely on Media Library for the home/about avatar unless you edit partials.
- If an old white-bg avatar still shows: purge cache (below) and hard-refresh (`Ctrl+F5`).

## Cache purge (required on this host — LiteSpeed)
1. **LiteSpeed Cache** → Toolbox → Purge All (or Quic.cloud / LSCache purge).
2. If **WP Rocket** / **Cloudflare**: purge everything.
3. Browser: hard refresh or private window.
4. Confirm asset URL includes a new `?ver=` query, e.g.  
   `/wp-content/themes/hello-child-mj/assets/img/avatar.png?ver=…`

## WP Admin checks
1. **Settings → Reading**: homepage = **Home / خانه** page.
2. Each portfolio page content should contain shortcode: `[mj_home]`, `[mj_about]`, etc. (or Elementor Shortcode widget with the same).
3. Page template can stay **Default** — child theme `page.php` is already a blank canvas. Elementor Canvas is optional, not required.
4. **Elementor → Settings**: disable Hello theme header/footer if Theme Builder header appears.
5. **Settings → General**: change site title from “My Blog” to brand name.
6. Viewport ≥ **1200px** to see home/about avatar (matches Next.js `xl` breakpoint).

## Known live issues addressed in 1.0.3
- Swiper handle collision with Elementor (`swiper` → `mj-swiper`)
- Avatar size/position closer to Next.js (737×678, end 8%)
- Cache-bust + `mj_img_uri()` / `get_theme_file_uri`
- Fade-in stuck at opacity 0 (above-fold + safety net)
- Stronger Hello/Elementor header hide
