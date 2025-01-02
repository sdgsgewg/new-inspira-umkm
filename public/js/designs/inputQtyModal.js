document.addEventListener("DOMContentLoaded", function () {
    const qtyElement = document.querySelector(".qty");
    const qtyInput = document.querySelector("#quantity");
    const btnIncrement = document.querySelector(".btn-increment");
    const btnDecrement = document.querySelector(".btn-decrement");
    const submitButton = document.getElementById("quantitySubmitButton");
    const form = document.getElementById("quantityForm");

    let qty = 1;

    function updateButtonStates() {
        function updateButtonState(button, isDisabled) {
            button.disabled = isDisabled;
            button.classList.toggle("btn-secondary", isDisabled);
            button.classList.toggle("btn-primary", !isDisabled);
        }

        // Update decrement button
        updateButtonState(btnDecrement, qty <= 1);

        // Update increment button
        updateButtonState(btnIncrement, qty >= design.stock);
    }

    function updateQuantityDisplay() {
        // Update visible quantity and hidden input
        qtyElement.textContent = qty;
        qtyInput.value = qty;
    }

    function initialize() {
        // Initialize button states and quantity display
        updateButtonStates();
        updateQuantityDisplay();
    }

    // Increment button click handler
    btnIncrement.addEventListener("click", () => {
        if (qty < design.stock) {
            qty += 1;
            updateQuantityDisplay();
            updateButtonStates();
        }
    });

    // Decrement button click handler
    btnDecrement.addEventListener("click", () => {
        if (qty > 1) {
            qty -= 1;
            updateQuantityDisplay();
            updateButtonStates();
        }
    });

    // Initialize on page load
    initialize();

    // Change button text dynamically based on action
    document
        .getElementById("quantityModal")
        .addEventListener("show.bs.modal", function (event) {
            const button = event.relatedTarget;
            const action = button.getAttribute("data-action");
            const route = button.getAttribute("data-route");
            const submit = button.getAttribute("data-submit");

            // Update form action
            form.setAttribute("action", route);

            if (action === "add-to-cart") {
                submitButton.textContent = submit;
                submitButton.classList.remove("btn-success");
                submitButton.classList.add("btn-primary");
            } else if (action === "checkout") {
                submitButton.textContent = submit;
                submitButton.classList.remove("btn-primary");
                submitButton.classList.add("btn-success");
            }
        });
});
