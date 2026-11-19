# Elementor HTML widget blueprints

Prefer shortcodes `[mj_home]` … `[mj_contact]` for full fidelity (particles, swipers, etc.).

If you rebuild a page from scratch in Elementor:

1. Section → full width, min-height 100vh, no gap, 0 padding.
2. Add an **HTML** widget and paste a shortened shell, **or** a **Shortcode** widget.

## Example: bilingual heading (HTML widget)

```html
<h1 class="mj-h1 mj-fade" data-dir="down" data-delay="0.2">
  <span class="mj-block-fa">ایده‌ها را<br>به <span class="mj-accent">واقعیت دیجیتال</span></span>
  <span class="mj-block-en">Transforming Ideas<br>Into <span class="mj-accent">Digital Reality</span></span>
</h1>
```

## Example: particles mount (Home only)

```html
<div id="mj-particles" style="position:absolute;inset:0;"></div>
```

Child theme JS will initialize tsparticles when `#mj-particles` exists.

## Example: counter

```html
<div class="mj-counter__num" data-end="10" data-duration="5">0</div>
```

## Classes cheat sheet

| Class | Role |
|-------|------|
| `mj-fade` + `data-dir` + `data-delay` | Entrance animation |
| `mj-only-fa` / `mj-only-en` | Inline bilingual |
| `mj-block-fa` / `mj-block-en` | Block bilingual |
| `mj-accent` | `#F13024` text |
| `mj-swiper-services` / `work` / `testimonials` | Swiper roots |

Full markup lives in `hello-child-mj/partials/` — copy from there into HTML widgets when needed.
