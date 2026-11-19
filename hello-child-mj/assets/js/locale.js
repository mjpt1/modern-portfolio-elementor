/**
 * Locale switcher — FA/EN + dir + body class + localStorage
 * Also syncs WP's body.rtl so LTR/EN layouts are not stuck RTL.
 */
(function () {
  "use strict";

  var KEY = (window.MJPortfolio && MJPortfolio.storageKey) || "modern-portfolio-locale";
  var DEFAULT = (window.MJPortfolio && MJPortfolio.defaultLocale) || "fa";

  function getLocale() {
    try {
      return localStorage.getItem(KEY) || DEFAULT;
    } catch (e) {
      return DEFAULT;
    }
  }

  function setLocale(locale) {
    locale = locale === "en" ? "en" : "fa";
    try {
      localStorage.setItem(KEY, locale);
    } catch (e) {}
    applyLocale(locale);
  }

  function applyLocale(locale) {
    var dir = locale === "fa" ? "rtl" : "ltr";
    document.documentElement.setAttribute("dir", dir);
    document.documentElement.setAttribute("lang", locale === "fa" ? "fa" : "en");
    document.body.classList.remove("mj-locale-fa", "mj-locale-en");
    document.body.classList.add("mj-locale-" + locale);

    // WordPress may add body.rtl from site language — keep it in sync with UI locale
    if (locale === "fa") {
      document.body.classList.add("rtl");
    } else {
      document.body.classList.remove("rtl");
    }

    var buttons = document.querySelectorAll(".mj-locale__btn");
    buttons.forEach(function (btn) {
      var isActive = btn.getAttribute("data-locale") === locale;
      btn.setAttribute("aria-pressed", isActive ? "true" : "false");
    });

    document.dispatchEvent(new CustomEvent("mj:localechange", { detail: { locale: locale } }));
  }

  function bind() {
    document.querySelectorAll(".mj-locale__btn").forEach(function (btn) {
      btn.addEventListener("click", function () {
        setLocale(btn.getAttribute("data-locale"));
      });
    });
  }

  function init() {
    applyLocale(getLocale());
    bind();
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", init);
  } else {
    init();
  }

  window.MJLocale = { get: getLocale, set: setLocale };
})();
