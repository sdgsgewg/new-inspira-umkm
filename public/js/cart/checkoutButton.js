document.addEventListener("DOMContentLoaded", function () {
    const checkoutButton = document.getElementById("checkout-button");
    const designCheckboxes = document.querySelectorAll(".check-design");
    const sellerCheckboxes = document.querySelectorAll(".check-seller");
    const modalMsg = document.getElementById("cartModalMessage");

    function updateModalMessage(isCheckedTotal) {
        const message =
            isCheckedTotal > 0
                ? "Please select designs from only one seller to proceed with checkout."
                : "No design selected. Please choose at least one design to continue.";

        modalMsg.textContent = message;
    }

    function updateCheckoutButton() {
        const checkoutURL = checkoutButton.getAttribute("data-checkout-url");

        let checkDesignAmount = [];
        let valid = false;

        sellerCheckboxes.forEach((sellerCheckbox) => {
            const sellerId = sellerCheckbox.getAttribute("data-seller-id");
            const designCheckboxesPerSeller = document.querySelectorAll(
                `.check-design[data-seller-id="${sellerId}"]`
            );
            let checkDesign = 0;
            designCheckboxesPerSeller.forEach((designCheckbox) => {
                if (designCheckbox.checked) {
                    checkDesign++;
                }
            });
            checkDesignAmount.push(checkDesign);
        });

        let count = 0,
            isCheckedTotal = 0;

        for (let i = 0; i < checkDesignAmount.length; i++) {
            isCheckedTotal += checkDesignAmount[i];
            if (checkDesignAmount[i] > 0) {
                count++;
            }
        }

        if (count == 1) {
            valid = true;
        }

        if (valid) {
            checkoutButton.setAttribute("href", checkoutURL);
            updateModalMessage(isCheckedTotal);
        } else {
            checkoutButton.removeAttribute("href");
            updateModalMessage(isCheckedTotal);
        }

        checkoutButton.classList.toggle("btn-primary", valid);
        checkoutButton.classList.toggle("btn-secondary", !valid);
    }

    function handleCheckoutClick(event) {
        if (!checkoutButton.getAttribute("href")) {
            event.preventDefault(); // Prevent navigation
            const modal = new bootstrap.Modal(
                document.getElementById(`cartModal`)
            );
            modal.show();
        }
    }

    designCheckboxes.forEach((checkbox) => {
        checkbox.addEventListener("change", updateCheckoutButton);
    });

    sellerCheckboxes.forEach((sellerCheckbox) => {
        sellerCheckbox.addEventListener("change", updateCheckoutButton);
    });

    checkoutButton.addEventListener("click", handleCheckoutClick);
    updateCheckoutButton();
});
