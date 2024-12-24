// const name = document.querySelector("#name");
// const username = document.querySelector("#username");

// name.addEventListener("change", function () {
//     fetch("/users/checkSlug?name=" + name.value)
//         .then((response) => response.json())
//         .then((data) => (username.value = data.username));
// });

function previewImage() {
    const image = document.querySelector("#image");
    const imgPreview = document.querySelector(".img-preview");

    imgPreview.style.display = "block";

    const oFReader = new FileReader();
    oFReader.readAsDataURL(image.files[0]);

    oFReader.onload = function (oFREvent) {
        imgPreview.src = oFREvent.target.result;
    };
}
