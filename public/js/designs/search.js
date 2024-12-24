function validateSearch(form) {
    const searchInput = form.search.value.trim(); // Get the search input and trim whitespace
    console.log("Validating search input:", searchInput); // Log validation step
    if (!searchInput) {
        console.warn("Search input is empty."); // Log if input is empty
        return false; // Prevent form submission
    }
    return true; // Allow form submission
}

document.addEventListener("DOMContentLoaded", function () {
    const searchForms = document.querySelectorAll("form[class^='searchForm']");

    searchForms.forEach((form) => {
        const formId = form.classList[0].replace("searchForm", ""); // Extract dynamic ID
        const searchInput = form.querySelector(`.searchInput${formId}`);
        const searchResults = document.querySelector(`.searchResults${formId}`);

        if (searchInput) {
            searchInput.addEventListener("keyup", function () {
                const query = searchInput.value.trim();

                if (query.length > 0) {
                    fetchResults(query, formId);
                } else if (searchResults) {
                    searchResults.innerHTML = "";
                }
            });
        }

        // Add click event listener to result items
        if (searchResults) {
            searchResults.addEventListener("click", function (event) {
                const target = event.target;
                if (target.classList.contains("result-item")) {
                    const title = target.getAttribute("data-title"); // Get the title
                    if (title && searchInput) {
                        searchInput.value = title; // Populate search bar
                        searchResults.innerHTML = ""; // Clear results
                    }
                }
            });
        }
    });
});

function fetchResults(query, id) {
    const form = document.querySelector(`.searchForm${id}`);
    const url = new URL(`/filtered-designs`, window.location.origin);

    // Include existing query parameters
    const formData = new FormData(form);
    for (const [key, value] of formData.entries()) {
        url.searchParams.append(key, value);
    }

    // Add the current search query
    url.searchParams.set("search", query);

    fetch(url.toString(), {
        method: "GET",
        headers: {
            "X-Requested-With": "XMLHttpRequest",
        },
    })
        .then((response) => response.json())
        .then((data) => {
            const searchResults = document.querySelector(`.searchResults${id}`);
            if (data.html) {
                if (searchResults) {
                    searchResults.innerHTML = data.html;
                }
            } else {
                console.error("No HTML returned in response");
            }
        })
        .catch((error) => {
            console.error("Error fetching results:", error);
        });
}
