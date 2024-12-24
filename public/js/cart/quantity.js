document.addEventListener("DOMContentLoaded", function () {
    function updateQuantity(designId, newQuantity) {
        fetch(`${qtyURL}`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-Token": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
            body: JSON.stringify({ design_id: designId, quantity: newQuantity }),
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    const quantityElement = document.querySelector(
                        `.qty[data-design-id="${designId}"]`
                    );

                    quantityElement.textContent = newQuantity;

                    quantityElement.setAttribute("data-qty", newQuantity);
                } else {
                    alert("Failed to update the quantity. Please try again.");
                }
            })
            .catch((error) => {
                console.error("Error updating quantity:", error);
                alert("An error occurred. Please try again.");
            });
    }

    const decrementButtons = document.querySelectorAll(".btn-decrement");
    decrementButtons.forEach((button) => {
        button.addEventListener("click", function () {
            const designId = this.closest(".cartItem")
                .querySelector(".qty")
                .getAttribute("data-design-id");
            const currentQuantity = parseInt(
                this.closest(".cartItem")
                    .querySelector(".qty")
                    .getAttribute("data-qty")
            );

            if (currentQuantity > 1) {
                updateQuantity(designId, currentQuantity - 1);
            } else {
                const modal = new bootstrap.Modal(
                    document.getElementById(`removeModal-${designId}`)
                );
                modal.show();
            }
        });
    });

    const incrementButtons = document.querySelectorAll(".btn-increment");
    incrementButtons.forEach((button) => {
        button.addEventListener("click", function () {
            const designId = this.closest(".cartItem")
                .querySelector(".qty")
                .getAttribute("data-design-id");
            const currentQuantity = parseInt(
                this.closest(".cartItem")
                    .querySelector(".qty")
                    .getAttribute("data-qty")
            );
            const designStock = parseInt(
                this.closest(".cartItem")
                    .querySelector(".qty")
                    .getAttribute("data-design-stock")
            );

            if (currentQuantity < designStock) {
                updateQuantity(designId, currentQuantity + 1);
            } else {
                const modal = new bootstrap.Modal(
                    document.getElementById(`maxQtyModal-${designId}`)
                );
                modal.show();
            }
        });
    });
});
