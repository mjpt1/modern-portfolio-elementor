/**
 * tsparticles home background (matches ParticlesContainer.jsx)
 */
(function () {
  "use strict";

  function initParticles() {
    var el = document.getElementById("mj-particles");
    if (!el || typeof tsParticles === "undefined") return;

    tsParticles.load("mj-particles", {
      fullScreen: { enable: false },
      background: { color: { value: "" } },
      fpsLimit: 120,
      interactivity: {
        events: {
          onClick: { enable: false, mode: "push" },
          /* Disabled: canvas sat above copy and stole hover / looked like bg-over-text */
          onHover: { enable: false, mode: "repulse" },
          resize: true,
        },
        modes: {
          push: { quantity: 90 },
          repulse: { distance: 200, duration: 0.4 },
        },
      },
      particles: {
        color: { value: "#e68e2e" },
        links: {
          color: "#f5d393",
          distance: 150,
          enable: true,
          opacity: 0.5,
          width: 1,
        },
        collisions: { enable: true },
        move: {
          direction: "none",
          enable: true,
          outModes: { default: "bounce" },
          random: false,
          speed: 1,
          straight: false,
        },
        number: {
          density: { enable: true, area: 800 },
          value: 80,
        },
        opacity: { value: 0.5 },
        shape: { type: "circle" },
        size: { value: { min: 1, max: 5 } },
      },
      detectRetina: true,
    }).then(function () {
      var host = document.getElementById("mj-particles");
      if (!host) return;
      host.style.pointerEvents = "none";
      var canvas = host.querySelector("canvas");
      if (canvas) canvas.style.pointerEvents = "none";
    });
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initParticles);
  } else {
    initParticles();
  }
})();
