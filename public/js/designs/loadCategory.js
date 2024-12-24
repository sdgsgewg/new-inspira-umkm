$(document).ready(function () {
    if (oldProductId) {
        loadCategoriesByProduct(oldProductId);
        $("#product").val(oldProductId);
    }

    function loadCategoriesByProduct(productId) {
        if (productId) {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });

            $.ajax({
                url: routeGetCategoriesByProduct.replace(":id", productId),
                type: "GET",
                dataType: "json",
                success: function (data) {
                    console.log("Data received from AJAX:", data); // Log the received data
                    $("#category").empty(); // Clear previous category options

                    // Check if categories exist
                    if (data.length > 0) {
                        $.each(data, function (key, value) {
                            var isSelected = oldCategoryId.includes(value.id) ? "selected" : "";

                            // Build the option element
                            var listItem = 
                                `<option value="${value.id }" ${isSelected}>${value.name}</option>`;

                            // Append the option to the category select list
                            $("#category").append(listItem);
                        });
                    } else {
                        // If no categories found, show a default message
                        $("#category").append('<option value="">No categories found for this product</option>');
                    }
                },
                error: function (xhr) {
                    console.error(xhr); // Log any errors
                },
            });
        } else {
            // If no product ID, clear the category select list
            $("#category").empty();
        }
    }

    // Event listener for product change
    $("#product").change(function () {
        var productId = $(this).val();
        loadCategoriesByProduct(productId);
    });
});
