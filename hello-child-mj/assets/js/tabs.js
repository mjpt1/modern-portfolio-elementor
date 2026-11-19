/**
 * About tabs helper — only one panel visible; aria + hidden attribute sync
 */
(function () {
  "use strict";

  function activate(root, index) {
    var buttons = root.querySelectorAll(".mj-tabs__btn");
    var panels = root.querySelectorAll(".mj-tabs__panel");
    buttons.forEach(function (b, i) {
      var on = i === index;
      b.classList.toggle("is-active", on);
      b.setAttribute("aria-selected", on ? "true" : "false");
      b.setAttribute("tabindex", on ? "0" : "-1");
    });
    panels.forEach(function (p, i) {
      var on = i === index;
      p.classList.toggle("is-active", on);
      if (on) {
        p.removeAttribute("hidden");
      } else {
        p.setAttribute("hidden", "");
      }
    });
  }

  function initTabs(root) {
    var buttons = root.querySelectorAll(".mj-tabs__btn");
    buttons.forEach(function (btn, i) {
      btn.addEventListener("click", function (e) {
        e.preventDefault();
        activate(root, i);
      });
      btn.addEventListener("keydown", function (e) {
        var next = i;
        if (e.key === "ArrowRight" || e.key === "ArrowLeft") {
          e.preventDefault();
          var dir = document.documentElement.getAttribute("dir") === "rtl" ? -1 : 1;
          if (e.key === "ArrowLeft") dir = -dir;
          next = (i + dir + buttons.length) % buttons.length;
          buttons[next].focus();
          activate(root, next);
        }
      });
    });
    // Ensure inactive panels are hidden on load
    activate(root, 0);
  }

  function init() {
    document.querySelectorAll("[data-mj-tabs]").forEach(initTabs);
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", init);
  } else {
    init();
  }
})();
