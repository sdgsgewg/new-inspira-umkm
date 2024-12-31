document.addEventListener("DOMContentLoaded", () => {
    // Main menu
    const mainMenu = document.querySelector(".dropdown-menu.main-menu");

    // Subscription Menu
    const subsMenu = document.querySelector(
        ".dropdown-menu.subscriptions-menu"
    );
    // Localization Menu
    const localizationMenu = document.querySelector(
        ".dropdown-menu.localization-menu"
    );
    // Color Theme Menu
    const themeMenu = document.querySelector(".color-theme-menu");

    // Trigger dropdown menu switch button
    const subsButton = document.getElementById("subscriptions-button");
    const localizationButton = document.getElementById("localization-button");
    const themeButton = document.getElementById("color-theme-button");

    // Back to Main Menu
    const backToMainMenuButtons =
        document.querySelectorAll(".back-to-main-menu");

    // Show Subscriptions Menu
    subsButton.addEventListener("click", (e) => {
        e.stopPropagation();
        mainMenu.classList.remove("show");
        subsMenu.classList.add("show");
    });

    // Show Localization Menu
    localizationButton.addEventListener("click", (e) => {
        e.stopPropagation();
        mainMenu.classList.remove("show");
        localizationMenu.classList.add("show");
    });

    // Show Color Theme Menu
    themeButton.addEventListener("click", (e) => {
        e.stopPropagation();
        mainMenu.classList.remove("show");
        themeMenu.classList.toggle("show");
    });

    // Kembali ke menu utama untuk semua tombol "back-to-main-menu"
    backToMainMenuButtons.forEach((button) => {
        button.addEventListener("click", (e) => {
            e.stopPropagation(); // Mencegah penutupan otomatis
            subsMenu.classList.remove("show");
            localizationMenu.classList.remove("show");
            themeMenu.classList.remove("show");
            mainMenu.classList.add("show");
        });
    });
});
