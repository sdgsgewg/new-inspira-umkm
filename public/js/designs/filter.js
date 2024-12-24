$(document).ready(function () {
    console.log("Old Product Slug:", oldProductSlug);
    console.log("Old Category Slugs:", oldCategorySlugs);

    if (oldProductSlug) {
        $("#product").val(oldProductSlug);
        loadCategoriesByProduct(oldProductSlug);
    }

    function loadCategoriesByProduct(productSlug) {
        if (productSlug) {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
            });

            $.ajax({
                url: routeGetCategoriesByProduct.replace(":slug", productSlug),
                type: "GET",
                dataType: "json",
                success: function (data) {
                    console.log("Data received from AJAX:", data);
                    $("#category").empty();
                    if (data.length > 0) {
                        $.each(data, function (key, value) {
                            var isChecked =
                                oldCategorySlugs &&
                                oldCategorySlugs.includes(value.slug)
                                    ? "checked"
                                    : "";

                            // Translate category name using categories object
                            var categoryName =
                                categories[value.name] || value.name; // Fallback to original value if not found in categories

                            var listItem = `<li class="list-group-item">
                                    <input class="form-check-input me-1" type="checkbox" name="category[]" value="${value.slug}" ${isChecked} id="CheckboxStretched${key}">
                                    <label class="form-check-label stretched-link" for="CheckboxStretched${key}">
                                        ${categoryName}
                                    </label>
                                </li>`;
                            $("#category").append(listItem);
                        });
                    } else {
                        // Use the translated message if no categories are found
                        $("#category").append(
                            `<li class="list-group-item">
                                ${lang.categoryErrorMsg}
                            </li>`
                        );
                    }
                },
                error: function (xhr) {
                    console.error(xhr);
                },
            });
        } else {
            $("#category").empty();
        }
    }

    $("#product").change(function () {
        var productSlug = $(this).val();
        loadCategoriesByProduct(productSlug);
    });
});
