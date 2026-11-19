# Hello Child MJ 1.1.1 — Deploy & RTL License

## Zip paths
- `C:\Users\mjpt1\Desktop\hello-child-mj.zip`
- `C:\Users\mjpt1\Desktop\job\new\modern-portfolio-elementor\hello-child-mj.zip`

## RTL License
- Class file (do not edit / do not encode): `RTL_License_34993e08830e4d32.php`
- Expected SHA1: `8d0148b7dbaa15f621989d47bf73b49d42ce648b`
- Snippet lives in `functions.php` — **this is the file to upload to the RTL encoder**
- After encoding: replace theme `functions.php` with the encoded file; keep the license class as provided

## Behavior
- Without license: front-end demo works; Portfolio Settings menu hidden; admin warning notice
- With license: Portfolio Settings menu + save/reset handlers enabled

## Upload
1. Appearance → Themes → Add New → Upload Theme → replace
2. Parent theme Hello Elementor required
3. Activate child theme → activate RTL license → open تنظیمات پورتفولیو
4. Purge LiteSpeed / Cloudflare cache
