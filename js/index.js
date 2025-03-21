document.addEventListener("DOMContentLoaded", function () {
    function adjustSlideshowPosition() {
        const header = document.querySelector(".navbar");
        const carousel = document.getElementById("gameCarousel");

        if (header && carousel) {
            let headerHeight = header.offsetHeight;
            carousel.style.marginTop = headerHeight + "px";
        }
    }

    adjustSlideshowPosition();
    window.addEventListener("resize", adjustSlideshowPosition);
});