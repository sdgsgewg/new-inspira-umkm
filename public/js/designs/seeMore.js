function toggleContent() {
    const moreContent = document.querySelector(`.moreContent`);
    const button = document.querySelector(`.toggleBtn`);

    if (
        moreContent.style.display === "none" ||
        moreContent.style.display === ""
    ) {
        moreContent.style.display = "block";
        button.textContent = button.dataset.textSeeLess;
    } else {
        moreContent.style.display = "none";
        button.textContent = button.dataset.textSeeMore;
    }

    // Inisialisasi ulang carousel jika ada
    moreContent.querySelectorAll(".carousel").forEach(initializeCarousel);
}
