# راهنمای نصب / Install Guide

برای LocalWP یا XAMPP — فارسی + English.

---

## فارسی

### پیش‌نیاز
- وردپرس ۶+
- قالب **Hello Elementor**
- افزونه **Elementor** (نسخه رایگان کافی است)
- اختیاری: Contact Form 7 یا WPForms Lite برای فرم تماس واقعی
- اختیاری: Elementor Pro فقط اگر Form / Motion Effects / Theme Builder می‌خواهید

### مراحل LocalWP
1. سایت جدید بسازید (PHP 8.1+ پیشنهادی).
2. وارد پیشخوان شوید.
3. **افزونه‌ها → افزودن:** Elementor را نصب و فعال کنید.
4. **ظاهر → پوسته‌ها → افزودن:** Hello Elementor را نصب کنید (فعال نکنید هنوز، یا فعال کنید بعد child را بگذارید).
5. پوشه `hello-child-mj` را کپی کنید به:
   `...\app\public\wp-content\themes\hello-child-mj`
6. **ظاهر → پوسته‌ها:** پوسته **Hello Child MJ Portfolio** را فعال کنید.
7. با فعال‌سازی، صفحات دمو ساخته می‌شوند و Home صفحه اصلی می‌شود.
8. از منوی پایین/کناری بین صفحات جابه‌جا شوید؛ دکمه فارسی/English را تست کنید.
9. برای ویرایش بصری: هر صفحه → ویرایش با المنتور.

### XAMPP
همان مراحل؛ مسیر تم معمولاً:
`C:\xampp\htdocs\yoursite\wp-content\themes\hello-child-mj`

### ایمپورت قالب‌های Elementor
1. المنتور → قالب‌ها → قالب‌های ذخیره‌شده → درون‌ریزی
2. فایل‌های `elementor/templates/page-*.json` را یکی‌یکی وارد کنید
3. داخل صفحه، از My Templates درج کنید

### فونت و CDN در ایران
اگر Google Fonts یا jsDelivr لود نشد:
- فونت وزیری‌متن را لوکال در `assets/fonts` بگذارید و در `functions.php` enqueue کنید
- یا از آینه‌هایی مثل `fonts.bunny.net` استفاده کنید
- Swiper/tsparticles را هم می‌توانید لوکال کپی کنید

### فرم تماس
- **رایگان:** Contact Form 7 بسازید → شورت‌کد را در صفحه Contact (جایگزین فرم دمو) بگذارید
- **Pro:** ویجت Form المنتور

### ویرایش محتوا
- سریع: فایل‌های `hello-child-mj/partials/*.php`
- بصری: Edit with Elementor + کلاس‌های `mj-only-fa` / `mj-only-en`

---

## English

### Requirements
- WordPress 6+
- **Hello Elementor** parent theme
- **Elementor** Free (enough for this kit)
- Optional: CF7 / WPForms Lite; Elementor Pro for native Form / Motion Effects / Theme Builder

### Steps
1. Create a LocalWP (or XAMPP) site.
2. Install Elementor + Hello Elementor.
3. Copy `hello-child-mj` into `wp-content/themes/`.
4. Activate **Hello Child MJ Portfolio**.
5. Demo pages are created automatically; Home is the front page.
6. Optionally import `elementor/templates/*.json`.
7. Edit copy in partials or via Elementor.

### Free vs Pro
- Wipe, particles, Swiper, counters, fade-in, locale: **child theme** (Free).
- Elementor Motion Effects / Form widget: **Pro only** — fallbacks provided.

### Media
Copy or upload from `demo/media/` (also already inside the child theme `assets/img/`).
