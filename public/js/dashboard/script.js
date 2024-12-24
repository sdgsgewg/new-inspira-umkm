const slug = document.querySelector("#slug");
const c = choice;

if (c === "design") {
    const title = document.querySelector("#title");

    title.addEventListener("change", function () {
        fetch(`/dashboard/${c}/checkSlug?title=${title.value}`)
            .then((response) => response.json())
            .then((data) => (slug.value = data.slug));
    });
} else if (c === "option-values") {
    const value = document.querySelector("#value");

    value.addEventListener("change", function () {
        fetch(`/dashboard/${c}/checkSlug?value=${value.value}`)
            .then((response) => response.json())
            .then((data) => (slug.value = data.slug));
    })
} else {
    const name = document.querySelector("#name");

    name.addEventListener("change", function () {
        fetch(`/dashboard/${c}/checkSlug?name=${name.value}`)
            .then((response) => response.json())
            .then((data) => (slug.value = data.slug));
    });
}

document.addEventListener("trix-file-accept", function (e) {
    e.preventDefault();
});

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
