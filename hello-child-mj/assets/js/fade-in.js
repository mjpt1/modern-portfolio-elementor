/**
 * Fade-in on load / intersection (Framer fadeIn fallback for Elementor Free)
 * Hardened for full-viewport shells where IO + display:none avatars can miss.
 * Never leaves readable copy stuck at opacity:0.
 */
(function () {
  "use strict";

  function reveal(el, delay) {
    window.setTimeout(function () {
      el.classList.add("is-visible");
    }, delay || 0);
  }

  function isDisplayed(el) {
    return window.getComputedStyle(el).display !== "none";
  }

  function inViewport(el) {
    var rect = el.getBoundingClientRect();
    var vh = window.innerHeight || document.documentElement.clientHeight;
    var vw = window.innerWidth || document.documentElement.clientWidth;
    return rect.bottom > 0 && rect.top < vh && rect.right > 0 && rect.left < vw;
  }

  function prefersReducedMotion() {
    return (
      window.matchMedia &&
      window.matchMedia("(prefers-reduced-motion: reduce)").matches
    );
  }

  function schedule(el) {
    if (el.classList.contains("is-visible") || el.dataset.mjFadeScheduled) return;
    if (!isDisplayed(el)) return;
    el.dataset.mjFadeScheduled = "1";
    if (prefersReducedMotion()) {
      el.classList.add("is-visible");
      return;
    }
    var delay = parseFloat(el.getAttribute("data-delay") || "0") * 1000;
    reveal(el, delay);
  }

  function forceVisible(nodes) {
    nodes.forEach(function (n) {
      if (isDisplayed(n)) {
        n.classList.add("is-visible");
        n.dataset.mjFadeScheduled = "1";
      }
    });
  }

  function init() {
    var nodes = Array.prototype.slice.call(document.querySelectorAll(".mj-fade"));
    if (!nodes.length) return;

    if (prefersReducedMotion()) {
      forceVisible(nodes);
      return;
    }

    // Above-fold / avatar / home copy: don't wait on IO
    nodes.forEach(function (n) {
      if (n.getAttribute("data-mj-above-fold") === "1" || inViewport(n)) {
        schedule(n);
      }
    });

    if ("IntersectionObserver" in window) {
      var io = new IntersectionObserver(
        function (entries) {
          entries.forEach(function (entry) {
            if (!entry.isIntersecting) return;
            schedule(entry.target);
            io.unobserve(entry.target);
          });
        },
        { threshold: 0.01, rootMargin: "120px 0px" }
      );
      nodes.forEach(function (n) {
        if (!n.classList.contains("is-visible")) io.observe(n);
      });
    } else {
      nodes.forEach(schedule);
    }

    // When avatar switches from display:none → flex at xl, reveal it
    window.addEventListener(
      "resize",
      function () {
        nodes.forEach(function (n) {
          if (!n.classList.contains("is-visible") && isDisplayed(n)) schedule(n);
        });
      },
      { passive: true }
    );

    // Fast safety net — never leave content stuck at opacity:0
    window.setTimeout(function () {
      forceVisible(nodes.filter(function (n) {
        return !n.classList.contains("is-visible");
      }));
    }, 1200);

    // Absolute last resort
    window.setTimeout(function () {
      forceVisible(nodes);
    }, 2800);
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", init);
  } else {
    init();
  }
})();
