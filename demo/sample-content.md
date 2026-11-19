# Demo content notes

All bilingual demo copy is sourced from the Next.js locales:

- `modern-portfolio/locales/fa.js`
- `modern-portfolio/locales/en.js`

## Where it lives in this port

| Section | File |
|---------|------|
| Home hero | `hello-child-mj/partials/home.php` |
| About + counters + tabs | `partials/about.php` |
| Services slider | `partials/services.php` |
| Work grid slider | `partials/work.php` |
| Testimonials | `partials/testimonials.php` |
| Contact labels | `partials/contact.php` |
| Owner name / socials / nav | `hello-child-mj/functions.php` (`mj_render_site_shell`) |

## Media (`demo/media/` + theme `assets/img/`)

| File | Used on |
|------|---------|
| `avatar.png` | Home, About |
| `bg-explosion.png` | Home stage |
| `top-left-img.png` | Global decoration |
| `circles.png` | About / Services / Work |
| `bulb.png` | Services / Work |
| `rounded-text.png` + `circle-star.svg` | Home projects button |
| `thumb1.jpg` … `thumb4.jpg` | Work |
| `t-avt-1.png` … `t-avt-3.png` | Testimonials |
| `site-bg.svg` | Body background |

## WXR

A full WXR export is not required: theme activation creates the six pages with shortcodes. If you need Tools → Import, create pages manually with the shortcodes listed in `elementor/kits/kit-manifest.json`.

## Editing later in Elementor

1. Pages → open page → Edit with Elementor.
2. Shortcode widget shows live rendered partial.
3. To break out of PHP: replace shortcode with native widgets; keep `mj-only-fa` / `mj-only-en` for bilingual switching.
