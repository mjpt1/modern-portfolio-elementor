/**
 * Swiper initializers for services / work / testimonials
 */
(function () {
  "use strict";

  function init() {
    if (typeof Swiper === "undefined") return;

    document.querySelectorAll(".mj-swiper-services").forEach(function (el) {
      if (el.swiper) return;
      new Swiper(el, {
        freeMode: true,
        pagination: { el: el.querySelector(".swiper-pagination"), clickable: true },
        breakpoints: {
          320: { slidesPerView: 1, spaceBetween: 15 },
          640: { slidesPerView: 3, spaceBetween: 15 },
        },
      });
    });

    document.querySelectorAll(".mj-swiper-work").forEach(function (el) {
      if (el.swiper) return;
      new Swiper(el, {
        spaceBetween: 10,
        pagination: { el: el.querySelector(".swiper-pagination"), clickable: true },
      });
    });

    document.querySelectorAll(".mj-swiper-testimonials").forEach(function (el) {
      if (el.swiper) return;
      new Swiper(el, {
        navigation: {
          nextEl: el.querySelector(".swiper-button-next"),
          prevEl: el.querySelector(".swiper-button-prev"),
        },
        pagination: { el: el.querySelector(".swiper-pagination"), clickable: true },
      });
    });
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", init);
  } else {
    init();
  }

  // Re-init after Elementor frontend preview
  if (window.elementorFrontend && elementorFrontend.hooks) {
    elementorFrontend.hooks.addAction("frontend/element_ready/global", function () {
      init();
    });
  }
})();
