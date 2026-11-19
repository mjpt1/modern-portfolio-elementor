# Elementor kit / templates

## What’s included

| File | Purpose |
|------|---------|
| `templates/page-*.json` | Importable Elementor **page** templates (Shortcode widgets → `[mj_*]`) |
| `html-widgets/` | Static HTML blueprints if you prefer HTML widget paste over shortcodes |
| `kits/kit-manifest.json` | Color/typography kit notes for Elementor Site Settings |

## Import templates (Elementor Free)

1. Activate **Hello Child MJ Portfolio** first (so shortcodes exist).
2. Elementor → Templates → Saved Templates → Import Templates.
3. Import each `page-*.json`.
4. Open the matching WP page → Edit with Elementor → Folder icon → My Templates → Insert.

Or skip JSON import: keep the shortcode already placed in page content on theme activation (`[mj_home]`, etc.) and click **Edit with Elementor** → it will convert the shortcode block.

## Editable content

- **Fast path:** edit PHP partials in `hello-child-mj/partials/*.php` (bilingual FA/EN spans).
- **Elementor path:** replace Shortcode widget with Heading / Text / HTML widgets; duplicate FA+EN text with classes `mj-only-fa` / `mj-only-en` (or `mj-block-fa` / `mj-block-en`).
- Locale toggle in the header shows/hides the matching language.

## Site Settings (manual kit)

In Elementor → Site Settings:

- Primary: `#131424`
- Secondary: `#393A47`
- Accent: `#F13024`
- Fonts: Vazirmatn (FA) / Sora (EN) — already enqueued by child theme
