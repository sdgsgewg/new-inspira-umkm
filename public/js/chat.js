document.addEventListener("DOMContentLoaded", function () {
    const chatMessagesContainer = document.querySelector("#chat-messages");
    let lastMessageTimestamp = null;

    // Scroll to the bottom on initial load
    if (chatMessagesContainer) {
        scrollToBottom(chatMessagesContainer);
    }

    // Fetch initial messages and store the timestamp of the last message
    function initialFetchMessages() {
        axios
            .get(`/chats/${chatId}/messages`)
            .then((response) => {
                const messages = response.data;
                updateChatMessages(messages);
                if (messages.length > 0) {
                    // Set the last message timestamp to the timestamp of the last message
                    lastMessageTimestamp =
                        messages[messages.length - 1].created_at;
                }
            })
            .catch((error) => {
                console.error("Error fetching messages:", error);
            });
    }

    // Polling function to fetch new messages every 5 seconds
    function fetchNewMessages() {
        if (lastMessageTimestamp) {
            axios
                .get(`/chats/${chatId}/messages?after=${lastMessageTimestamp}`)
                .then((response) => {
                    const messages = response.data;
                    console.log(messages);
                    if (messages.length > 0) {
                        updateChatMessages(messages);
                        // Update the last message timestamp with the newest message
                        lastMessageTimestamp =
                            messages[messages.length - 1].created_at;
                    }
                })
                .catch((error) => {
                    console.error("Error fetching messages:", error);
                });
        }
    }

    // Update chat messages in the UI
    function updateChatMessages(messages) {
        const chatMessagesContainer = document.querySelector("#chat-messages");

        if (!messages || messages.length === 0) return;

        // Check the last message in the container, and ensure new messages come after it
        const lastMessage = chatMessagesContainer.querySelector(
            ".message:last-child"
        );
        const lastMessageTimestamp = lastMessage
            ? lastMessage.querySelector(".timestamp").textContent
            : null;

        // Append only new messages that haven't been displayed yet
        messages.forEach((message) => {
            // If we have already displayed this message, skip it
            if (
                lastMessageTimestamp &&
                new Date(lastMessageTimestamp) >= new Date(message.created_at)
            ) {
                return; // Skip if this message is already displayed
            }

            const isSender = message.sender_id === userId;
            const messageElement = `
                <div class="message ${isSender ? "sent" : "received"} pb-2">
                    <div class="message-bubble">
                        <p class="m-0">${message.message_text}</p>
                    </div>
                    <div class="message-info ${isSender ? "sent" : "received"}">
                        <span class="timestamp">${new Date(
                            message.created_at
                        ).toLocaleTimeString([], {
                            hour: "2-digit",
                            minute: "2-digit",
                        })}</span>
                    </div>
                </div>
            `;
            chatMessagesContainer.innerHTML += messageElement;
        });

        // Scroll to the bottom after updating messages
        scrollToBottom(chatMessagesContainer);
    }

    // Handle form submission to send messages
    document
        .querySelector("#chat-form")
        .addEventListener("submit", function (event) {
            event.preventDefault();

            const message = document.querySelector(
                'input[name="message"]'
            ).value;
            const chatId = document.querySelector("#chat").value;
            const csrfToken = document.querySelector(
                'input[name="_token"]'
            ).value;

            // Send the message via axios
            axios
                .post(chatStoreUrl, {
                    chat: chatId,
                    message: message,
                    _token: csrfToken,
                })
                .then((response) => {
                    // Clear the message input field after sending
                    document.querySelector('input[name="message"]').value = "";

                    // Only append the new message dynamically
                    const messageElement = `
                        <div class="message ${
                            response.data.sender_id === userId
                                ? "sent"
                                : "received"
                        } pb-2">
                            <div class="message-bubble">
                                <p class="m-0">${response.data.message}</p>
                            </div>
                            <div class="message-info ${
                                response.data.sender_id === userId
                                    ? "sent"
                                    : "received"
                            }">
                                <span class="timestamp">${
                                    response.data.timestamp
                                }</span>
                            </div>
                        </div>
                    `;
                    const chatMessagesContainer =
                        document.querySelector("#chat-messages");
                    chatMessagesContainer.innerHTML += messageElement;

                    // Scroll to the bottom after sending a message
                    scrollToBottom(chatMessagesContainer);
                })
                .catch((error) => {
                    console.error("Error sending message:", error);
                });
        });

    // Initial fetch when page loads
    initialFetchMessages();

    // Polling every 5 seconds
    setInterval(fetchNewMessages, 5000);
});

// Function to scroll to the bottom of the chat container
function scrollToBottom(container) {
    container.scrollTop = container.scrollHeight;
}
