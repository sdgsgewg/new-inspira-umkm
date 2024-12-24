// Handle cleaning up extra modal backdrops
document.addEventListener("hidden.bs.modal", function (event) {
    const modalBackdrops = document.querySelectorAll(".modal-backdrop");
    if (modalBackdrops.length > 1) {
        modalBackdrops.forEach((backdrop, index) => {
            if (index !== modalBackdrops.length - 1) {
                backdrop.remove();
            }
        });
    }
});
