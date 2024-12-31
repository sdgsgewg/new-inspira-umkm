document.addEventListener("DOMContentLoaded", function () {
    const statusLinks = document.querySelectorAll(".nav-underline .nav-link");
    const nav = document.querySelector(".nav-underline");
    const selectedStatus = nav.getAttribute("data-selected-status");
    const transactionCards = document.querySelectorAll(".transaction-card");
    const contentHaveOrder = document.getElementById("haveOrder");
    const contentNoOrder = document.getElementById("noOrder");

    // Function to display content based on selected status
    function displayContent(selectedStatus) {
        let hasOrder = false;

        // Convert NodeList to an array to apply sort
        let filteredCards = Array.from(transactionCards);

        // Sort transactions if status is 'Completed'
        if (selectedStatus === "Completed") {
            // Sort transaction cards by the created_at timestamp (most recent first)
            filteredCards.sort((a, b) => {
                const aCreatedAt = parseInt(a.getAttribute("data-created-at"));
                const bCreatedAt = parseInt(b.getAttribute("data-created-at"));
                return bCreatedAt - aCreatedAt; // Sort in descending order (newest first)
            });
        }

        // Filter and display cards based on selected status
        filteredCards.forEach((card) => {
            if (card.getAttribute("data-status") === selectedStatus) {
                card.style.display = "block";
                hasOrder = true;
            } else {
                card.style.display = "none";
            }
        });

        // Toggle content based on whether orders exist for selected status
        if (hasOrder) {
            contentHaveOrder.style.display = "block";
            contentNoOrder.style.display = "none";
        } else {
            contentHaveOrder.style.display = "none";
            contentNoOrder.style.display = "block";
        }
    }

    // Set initial active link and display filtered content based on it
    function initialize() {
        let activeLink = document.querySelector(
            ".nav-underline .nav-link.active"
        );
        if (!activeLink) {
            activeLink = document.querySelector(
                `.nav-underline .nav-link[data-status="${selectedStatus}"]`
            );
            activeLink.classList.add("active");
        }

        displayContent(activeLink.getAttribute("data-status"));
    }

    initialize();

    // Event listener for each nav-link
    statusLinks.forEach((navLink) => {
        navLink.addEventListener("click", function (e) {
            e.preventDefault();

            // Update active state on links
            statusLinks.forEach((link) => link.classList.remove("active"));
            this.classList.add("active");

            // Display content based on the clicked status
            const selectedStatus = this.getAttribute("data-status");
            displayContent(selectedStatus);
        });
    });
});
