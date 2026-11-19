/**
 * CountUp for About counters + Persian/English digit formatting
 * Hardened for overflow:auto shells (body overflow hidden + .mj-site-main scroll)
 * and display:none counters below md.
 */
(function () {
  "use strict";

  var FA_DIGITS = ["۰", "۱", "۲", "۳", "۴", "۵", "۶", "۷", "۸", "۹"];
  var started = false;

  function formatNumber(n, locale) {
    var s = String(Math.floor(n));
    if (locale === "fa") {
      return s.replace(/\d/g, function (d) {
        return FA_DIGITS[d];
      });
    }
    return s;
  }

  function animate(el) {
    var end = parseFloat(el.getAttribute("data-end") || "0");
    var duration = parseFloat(el.getAttribute("data-duration") || "5") * 1000;
    var start = 0;
    var t0 = null;

    function frame(ts) {
      if (!t0) t0 = ts;
      var p = Math.min((ts - t0) / duration, 1);
      var value = start + (end - start) * p;
      var locale = (window.MJLocale && MJLocale.get()) || "fa";
      el.textContent = formatNumber(value, locale);
      if (p < 1) requestAnimationFrame(frame);
    }
    requestAnimationFrame(frame);
  }

  function runAll() {
    if (started) {
      document.querySelectorAll(".mj-counter__num[data-end][data-done='1']").forEach(function (el) {
        var locale = (window.MJLocale && MJLocale.get()) || "fa";
        el.textContent = formatNumber(parseFloat(el.getAttribute("data-end")), locale);
      });
      return;
    }
    started = true;
    document.querySelectorAll(".mj-counter__num[data-end]").forEach(function (el) {
      el.setAttribute("data-done", "1");
      animate(el);
    });
  }

  function isDisplayed(el) {
    return window.getComputedStyle(el).display !== "none";
  }

  function init() {
    var nodes = document.querySelectorAll(".mj-counter__num[data-end]");
    if (!nodes.length) return;

    var host = nodes[0].closest(".mj-counters") || nodes[0];
    var scrollRoot = document.getElementById("mj-content") || null;

    function tryStart() {
      if (started) return;
      if (!isDisplayed(host)) return;
      runAll();
    }

    // Immediate if already on-screen and visible (desktop about)
    if (isDisplayed(host)) {
      var rect = host.getBoundingClientRect();
      var vh = window.innerHeight || document.documentElement.clientHeight;
      if (rect.top < vh && rect.bottom > 0) {
        window.setTimeout(tryStart, 200);
      }
    }

    if ("IntersectionObserver" in window) {
      var opts = { threshold: 0, rootMargin: "80px 0px" };
      if (scrollRoot) opts.root = scrollRoot;
      var io = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
          if (!entry.isIntersecting) return;
          tryStart();
          io.disconnect();
        });
      }, opts);
      io.observe(host);

      // Fallback if IO never fires (transform / overflow edge cases)
      window.setTimeout(function () {
        if (!started && isDisplayed(host)) tryStart();
      }, 1500);
    } else {
      tryStart();
    }

    // When counters switch display:none → flex at md+
    window.addEventListener(
      "resize",
      function () {
        if (!started && isDisplayed(host)) tryStart();
      },
      { passive: true }
    );
  }

  document.addEventListener("mj:localechange", function () {
    document.querySelectorAll(".mj-counter__num[data-end][data-done='1']").forEach(function (el) {
      var locale = (window.MJLocale && MJLocale.get()) || "fa";
      el.textContent = formatNumber(parseFloat(el.getAttribute("data-end")), locale);
    });
  });

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", init);
  } else {
    init();
  }
})();
