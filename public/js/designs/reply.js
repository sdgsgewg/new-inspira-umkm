function showReplyForm(id) {
    const replyForm = document.querySelector(`.replyForm[data-id="${id}"]`);

    replyForm.style.display = "block";
}

function handleReplyBtn(id) {
    const reply = document
        .querySelector(`.reply[data-id="${id}"]`)
        .value.trim();
    const replyBtn = document.querySelector(`.replyBtn[data-id="${id}"]`);

    if (reply.length > 0) {
        replyBtn.removeAttribute("disabled");
    } else {
        replyBtn.setAttribute("disabled", true);
    }
}

function hideReplyForm(id) {
    const replyForm = document.querySelector(`.replyForm[data-id="${id}"]`);
    const reply = document.querySelector(`.reply[data-id="${id}"]`);

    reply.value = "";
    replyForm.style.display = "none";

    handleReplyBtn(id);
}

function toggleReply(id) {
    const replySections = document.querySelectorAll(
        `.reply-section[data-id="${id}"]`
    );
    const toggleReplyBtn = document.querySelector(
        `.toggleReplyBtn[data-id="${id}"]`
    );

    replySections.forEach((replySection) => {
        if (replySection.style.display === "none") {
            replySection.style.display = "block";
            toggleReplyBtn.innerHTML = `<i class="bi bi-caret-up"></i> ${
                toggleReplyBtn.dataset.replyAmount
            } 
            ${toggleReplyBtn.dataset.replyAmount > 1 ? "Replies" : "Reply"}`;
        } else {
            replySection.style.display = "none";
            toggleReplyBtn.innerHTML = `<i class="bi bi-caret-down"></i> ${
                toggleReplyBtn.dataset.replyAmount
            } 
            ${toggleReplyBtn.dataset.replyAmount > 1 ? "Replies" : "Reply"}`;
        }
    });
}

function showReplyToReplyForm(id) {
    const replyToReplyForm = document.querySelector(
        `.replyToReplyForm[data-id="${id}"]`
    );

    replyToReplyForm.style.display = "block";
}

function hideReplyToReplyForm(id) {
    const replyToReplyForm = document.querySelector(
        `.replyToReplyForm[data-id="${id}"]`
    );

    replyToReplyForm.style.display = "none";
}

function handleReplyToReplyBtn(id) {
    const replyToReply = document
        .querySelector(`.replyToReply[data-id="${id}"]`)
        .value.trim();
    const replyToReplyBtn = document.querySelector(
        `.replyToReplyBtn[data-id="${id}"]`
    );

    if (replyToReply.length > 0) {
        replyToReplyBtn.removeAttribute("disabled");
    } else {
        replyToReplyBtn.setAttribute("disabled", true);
    }
}

function hideReplyToReplyForm(id) {
    const replyToReplyForm = document.querySelector(
        `.replyToReplyForm[data-id="${id}"]`
    );
    const replyToReply = document.querySelector(
        `.replyToReply[data-id="${id}"]`
    );

    replyToReply.value = "";
    replyToReplyForm.style.display = "none";

    handleReplyToReplyBtn(id);
}
