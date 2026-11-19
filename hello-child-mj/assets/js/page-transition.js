/**
 * Multi-layer purple page wipe (Framer Transition.jsx port)
 */
(function () {
  "use strict";

  var navigating = false;

  function isInternal(anchor) {
    if (!anchor || !anchor.href) return false;
    if (anchor.target && anchor.target !== "_self") return false;
    if (anchor.hasAttribute("download")) return false;
    var url = new URL(anchor.href, window.location.href);
    if (url.origin !== window.location.origin) return false;
    if (url.pathname === window.location.pathname && url.hash) return false;
    // Skip same-page
    if (url.href.split("#")[0] === window.location.href.split("#")[0]) return false;
    return true;
  }

  function playIn() {
    document.body.classList.remove("mj-wipe-out");
    document.body.classList.add("mj-wipe-in");
    window.setTimeout(function () {
      document.body.classList.remove("mj-wipe-in");
    }, 1400);
  }

  function playOut(href) {
    if (navigating) return;
    navigating = true;
    document.body.classList.remove("mj-wipe-in");
    document.body.classList.add("mj-wipe-out");
    window.setTimeout(function () {
      window.location.href = href;
    }, 700);
  }

  document.addEventListener("DOMContentLoaded", function () {
    playIn();

    document.addEventListener(
      "click",
      function (e) {
        var a = e.target.closest("a");
        if (!isInternal(a)) return;
        // Allow modified clicks
        if (e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return;
        e.preventDefault();
        playOut(a.href);
      },
      true
    );
  });
})();
