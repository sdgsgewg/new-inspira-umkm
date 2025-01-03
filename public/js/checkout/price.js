document.addEventListener("DOMContentLoaded", function () {
    const shippingMethodSelect = document.getElementById("shippingMethod");
    const shippingFeeDisplay = document.getElementById("shippingFeeDisplay");
    const grandTotalPriceDisplay = document.getElementById("grandTotalPriceDisplay");
    const shippingFeeInput = document.querySelector(
        'input[name="shippingFee"]'
    );
    const grandTotalPriceInput = document.querySelector('input[name="grandTotalPrice"]');

    // Fungsi untuk menghitung ulang total price
    const updateTotalPrice = () => {
        const selectedOption =
            shippingMethodSelect.options[shippingMethodSelect.selectedIndex];
        const shippingFee =
            parseFloat(selectedOption.getAttribute("data-shipping-fee")) || 0;
        const grandTotalPrice = subtotal + serviceFee + shippingFee;

        // Update tampilan shipping fee
        shippingFeeDisplay.textContent = `Rp${shippingFee.toLocaleString(
            "id-ID"
        )}`;

        // Update tampilan total price
        grandTotalPriceDisplay.textContent = `Rp${grandTotalPrice.toLocaleString(
            "id-ID"
        )}`;

        // Update nilai input shippingFee dan totalPrice
        shippingFeeInput.value = shippingFee;
        console.log(shippingFeeInput.value);
        grandTotalPriceInput.value = totalPrice;
        console.log(grandTotalPriceInput.value);
    };

    // Event listener untuk perubahan pada shipping method
    shippingMethodSelect.addEventListener("change", updateTotalPrice);

    // Inisialisasi awal jika ada opsi yang dipilih
    updateTotalPrice();
});
