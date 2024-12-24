function toggleCommentButtonVisibility() {
    const buttonContainer = document.getElementById("commentBtnContainer");

    if (buttonContainer.style.display === "none") {
        buttonContainer.style.display = "flex";
    } else {
        buttonContainer.style.display = "none";
    }
}

function handlePostBtn() {
    const comment = document.getElementById("comment").value.trim();
    const postBtn = document.getElementById("post");

    if (comment.length > 0) {
        postBtn.removeAttribute("disabled");
    } else {
        postBtn.setAttribute("disabled", true);
    }
}

// Function to hide button container on cancel
function hideCommentButtonContainer() {
    const buttonContainer = document.getElementById("commentBtnContainer");
    const comment = document.getElementById("comment");

    comment.value = "";
    buttonContainer.style.display = "none";

    handlePostBtn();
}
