/* This code below for JavaScript ES6 */
import "./contact-form";

("use strict");
$ = jQuery;
$(document).ready(function () {
  // ============================================================
  // Service Slider
  // ============================================================
  const sliderWrapper = document.getElementById("zippyServiceSlider");
  const prevBtn = document.getElementById("zippyServicePrev");
  const nextBtn = document.getElementById("zippyServiceNext");
  const dotsContainer = document.getElementById("zippyServiceDots");

  if (sliderWrapper && prevBtn && nextBtn) {
    let currentIndex = 0;
    let slidesPerView = getSlidesPerView();
    const cards = Array.from(
      sliderWrapper.querySelectorAll(".zippy-service-card"),
    );
    const totalCards = cards.length;
    const totalSlides = Math.ceil(totalCards / slidesPerView);

    // Build dots
    function buildDots() {
      if (!dotsContainer) return;
      dotsContainer.innerHTML = "";
      const slides = Math.ceil(totalCards / getSlidesPerView());
      for (let i = 0; i < slides; i++) {
        const dot = document.createElement("button");
        dot.className = "dot" + (i === currentIndex ? " is-active" : "");
        dot.setAttribute("aria-label", "Go to slide " + (i + 1));
        dot.addEventListener("click", () => goTo(i));
        dotsContainer.appendChild(dot);
      }
    }

    // Update active dot
    function updateDots() {
      if (!dotsContainer) return;
      Array.from(dotsContainer.querySelectorAll(".dot")).forEach((d, i) => {
        d.classList.toggle("is-active", i === currentIndex);
      });
    }

    // Get slides per view based on current viewport
    function getSlidesPerView() {
      if (window.innerWidth <= 600) return 1;
      if (window.innerWidth <= 992) return 2;
      return 3;
    }

    // Move to a specific slide index
    function goTo(index) {
      const spv = getSlidesPerView();
      const maxIndex = Math.max(0, totalCards - spv);
      currentIndex = Math.min(Math.max(index, 0), maxIndex);

      // Calculate offset: each card width + gap
      const cardEl = cards[0];
      const gap = parseInt(getComputedStyle(sliderWrapper).gap || "24", 10);
      const cardW = cardEl.getBoundingClientRect().width;
      const offset = currentIndex * (cardW + gap);

      sliderWrapper.style.transform = `translateX(-${offset}px)`;

      // Update buttons disabled state
      prevBtn.classList.toggle("is-disabled", currentIndex === 0);
      nextBtn.classList.toggle("is-disabled", currentIndex >= maxIndex);

      updateDots();
    }

    prevBtn.addEventListener("click", () => goTo(currentIndex - 1));
    nextBtn.addEventListener("click", () => goTo(currentIndex + 1));

    // Touch / swipe support
    let touchStartX = 0;
    sliderWrapper.addEventListener(
      "touchstart",
      (e) => {
        touchStartX = e.touches[0].clientX;
      },
      { passive: true },
    );
    sliderWrapper.addEventListener(
      "touchend",
      (e) => {
        const diff = touchStartX - e.changedTouches[0].clientX;
        if (Math.abs(diff) > 50) {
          goTo(currentIndex + (diff > 0 ? 1 : -1));
        }
      },
      { passive: true },
    );

    // Re-init on resize
    let resizeTimer;
    window.addEventListener("resize", () => {
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(() => {
        buildDots();
        goTo(0);
      }, 200);
    });

    // Init
    buildDots();
    goTo(0);
  }
});
