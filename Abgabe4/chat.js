// Global configuration - store in main.js or at top of chat.js
const backendUrl = "https://online-lectures-cs.thi.de/chat/ac6da607-6c49-49b2-a4ec-4ae662913054";
const token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyIjoiVG9tIiwiaWF0IjoxNzMyNDgwOTc5fQ.ipu8rFx07hVcOEe95OVsXx75L8mqjMuXxfk2rfDbS5k";

// Get chatpartner from URL using all possible parameter names
function getChatpartner() {
    const url = new URL(window.location.href);
    // Try different possible parameter names
    const friend = url.searchParams.get("friend")
    console.log("Chat partner:", friend); // Debug output
    return friend;
}

// Update chat header with friend's name
function updateChatHeader() {
    const friend = getChatpartner();
    const headerElement = document.querySelector("h1");
    if (headerElement && friend) {
        headerElement.textContent = `Chat with ${friend}`;
    }
}

// Load and display messages
function loadMessages() {
    const friend = getChatpartner();
    if (!friend) {
        console.error("No friend specified");
        return;
    }

    const xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4) {
            if (xmlhttp.status == 200) {
                const messages = JSON.parse(xmlhttp.responseText);
                displayMessages(messages);
            } else {
                console.error("Error loading messages:", xmlhttp.status);
            }
        }
    };

    xmlhttp.open("GET", `${backendUrl}/message/${friend}`, true);
    xmlhttp.setRequestHeader('Authorization', 'Bearer ' + token);
    xmlhttp.send();
}
window.sendMessage = sendMessage;

// Display messages in the chat
function displayMessages(messages) {
    // Find the message container
    const messageContainer = document.getElementById("message-container");
    if (!messageContainer) return;
    
    // Clear existing messages
    messageContainer.innerHTML = "";
    
    // Add all messages
    messages.forEach(message => {
        const messageElement = document.createElement("div");
        messageElement.className = "chat";
        messageElement.textContent = `${message.from}: "${message.msg}"`;
        messageContainer.appendChild(messageElement);
    });
}


// Send a new message
function sendMessage(event) {
    if (event) {
        event.preventDefault();
    }
    
    const friend = getChatpartner();
    const inputField = document.querySelector("input[type='text']");
    if (!friend) {
        console.error("No friend specified");
        return;
    }
    if (!inputField || !inputField.value.trim()) {
        console.error("No message to send");
        return;
    }

    // Correct format according to documentation
    const data = {
        message: inputField.value.trim(),
        to: friend
    };

    console.log("Sending message to:", friend);
    console.log("Message data:", data);

    const xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4) {
            if (xmlhttp.status == 204) {
                // Message sent successfully
                inputField.value = ""; // Clear input field
                loadMessages(); // Reload messages
            } else {
                console.error("Error sending message:", xmlhttp.status);
                console.error("Response:", xmlhttp.responseText);
            }
        }
    };

    // Correct endpoint - just /message without the recipient
    xmlhttp.open("POST", `${backendUrl}/message`, true);
    xmlhttp.setRequestHeader('Authorization', 'Bearer ' + token);
    xmlhttp.setRequestHeader('Content-Type', 'application/json');
    xmlhttp.send(JSON.stringify(data));
}

// Initialize chat functionality
function initializeChat() {
    // Update header with friend's name
    updateChatHeader();
    
    // Load initial messages
    loadMessages();
    
    // Set up periodic message loading
    window.setInterval(loadMessages, 1000);
}

document.addEventListener('DOMContentLoaded', function () {
    const sendButton = document.getElementById('send-button');
    if (sendButton) {
        sendButton.addEventListener('click', sendMessage);
    }
});


// Start everything when DOM is loaded
document.addEventListener('DOMContentLoaded', initializeChat);