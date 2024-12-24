function initializeCarousel(carousel) {
    const slider = carousel.querySelector(".carousel-inner");
    const prev = carousel.querySelector(".carousel-control-prev");
    const next = carousel.querySelector(".carousel-control-next");
    const designAmount = carousel.getAttribute("data-design-amount");

    let scrollAmount = 0;
    let visibleCards = getVisibleCards();
    let cardWidth = getCardWidth();

    function getVisibleCards() {
        const screenWidth = window.innerWidth;

        if (screenWidth >= 1200) {
            // Extra Large (xl)
            return 4;
        } else if (screenWidth >= 992) {
            // Large (lg)
            return 3;
        } else if (screenWidth >= 768) {
            // Medium (md)
            return 2;
        } else if (screenWidth >= 576) {
            // Small (sm)
            return 2;
        } else {
            // Extra Small (xs)
            return 1;
        }
    }

    function getCardWidth() {
        let item = carousel.querySelector(".carousel-item").offsetWidth + 20;
        return item;
    }

    function updateCarousel() {
        visibleCards = getVisibleCards();
        cardWidth = getCardWidth();
        scrollAmount = 0;
        slider.scroll({ left: scrollAmount, behavior: "smooth" });

        if (scrollAmount == 0) {
            prev.style.display = "none";
            if (designAmount <= visibleCards) {
                next.style.display = "none";
            } else {
                next.style.display = "flex";
            }
        }
    }

    window.addEventListener("resize", updateCarousel);

    next.addEventListener("click", () => {
        const maxScroll = slider.scrollWidth - slider.clientWidth - 20;
        if (scrollAmount < maxScroll) {
            scrollAmount += cardWidth;
            if (scrollAmount > maxScroll) {
                scrollAmount = maxScroll;
            }
            slider.scroll({
                left: scrollAmount,
                behavior: "smooth",
            });
            prev.style.display = "flex";
        }

        if (scrollAmount >= maxScroll) {
            next.style.display = "none";
        }
    });

    prev.addEventListener("click", () => {
        if (scrollAmount > 0) {
            scrollAmount -= cardWidth;
            if (scrollAmount < 0) {
                scrollAmount = 0;
            }
            slider.scroll({
                left: scrollAmount,
                behavior: "smooth",
            });
            next.style.display = "flex";
        }

        if (scrollAmount == 0) {
            prev.style.display = "none";
        }
    });

    if (scrollAmount == 0) {
        prev.style.display = "none";
        if (designAmount <= visibleCards) {
            next.style.display = "none";
        }
    }
}

// Initialize carousels on initial load
document.querySelectorAll(".carousel").forEach(initializeCarousel);

// Make the function globally accessible for seeMore.js
window.initializeCarousel = initializeCarousel;
