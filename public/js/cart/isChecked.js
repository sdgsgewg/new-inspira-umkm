document.addEventListener("DOMContentLoaded", function () {
    function updateIsChecked(designId, isChecked) {
        fetch(`${checkURL}`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-Token": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
            body: JSON.stringify({ design_id: designId, is_checked: isChecked }),
        })
            .then((response) => response.json())
            .then((data) => {
                if (!data.success) {
                    alert("Failed to update the cart item. Please try again.");
                }
            })
            .catch((error) => {
                console.error("Error updating isChecked:", error);
                alert("An error occurred. Please try again.");
            });
    }

    function updateSellerCheckbox(sellerId) {
        const sellerCheckbox = document.querySelector(
            `.check-seller[data-seller-id="${sellerId}"]`
        );
        const designCheckboxes = document.querySelectorAll(
            `.check-design[data-seller-id="${sellerId}"]`
        );

        const allChecked = Array.from(designCheckboxes).every(
            (checkbox) => checkbox.checked
        );
        sellerCheckbox.checked = allChecked;
        sellerCheckbox.indeterminate =
            !allChecked &&
            Array.from(designCheckboxes).some((checkbox) => checkbox.checked);
    }

    function updatedesignCheckboxes(sellerId) {
        const sellerCheckbox = document.querySelector(
            `.check-seller[data-seller-id="${sellerId}"]`
        );
        const designCheckboxes = document.querySelectorAll(
            `.check-design[data-seller-id="${sellerId}"]`
        );

        const isChecked = sellerCheckbox.checked;
        Array.from(designCheckboxes).forEach((checkbox) => {
            checkbox.checked = isChecked;
            const designId = checkbox.getAttribute("data-design-id");
            updateIsChecked(designId, isChecked);
        });
    }

    const designCheckboxes = document.querySelectorAll(".check-design");
    designCheckboxes.forEach((checkbox) => {
        checkbox.addEventListener("click", function () {
            const sellerId = this.getAttribute("data-seller-id");
            const designId = this.getAttribute("data-design-id");
            updateSellerCheckbox(sellerId);
            updateIsChecked(designId, this.checked);
        });
    });

    const sellerCheckboxes = document.querySelectorAll(".check-seller");
    sellerCheckboxes.forEach((checkbox) => {
        checkbox.addEventListener("change", function () {
            const sellerId = this.getAttribute("data-seller-id");
            updatedesignCheckboxes(sellerId);
        });
    });

    const sellerIds = [
        ...new Set(
            Array.from(designCheckboxes).map((checkbox) =>
                checkbox.getAttribute("data-seller-id")
            )
        ),
    ];
    sellerIds.forEach((sellerId) => {
        updateSellerCheckbox(sellerId);
    });
});
