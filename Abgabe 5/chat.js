document.addEventListener('DOMContentLoaded', function() {
    const messageForm = document.getElementById('message-form');
    const messageInput = document.getElementById('message-input');
    const sentMessagesContainer = document.getElementById('sent-messages-container');

    // Entfernen der vorherigen Event-Listener, um Mehrfachsendungen zu verhindern
    messageForm.removeEventListener('submit', handleFormSubmit);
    messageForm.addEventListener('submit', handleFormSubmit);

    function handleFormSubmit(event) {
        event.preventDefault();

        const message = messageInput.value.trim();
        if (message) {
            sendMessage(message);
            messageInput.value = '';
        } else {
            alert("Bitte gib eine Nachricht ein.");
        }
    }

    function displaySentMessage(message) {
        if (!sentMessagesContainer) return;
    
        // Überprüfen, ob die Nachricht bereits angezeigt wurde
        const messageKey = `${currentUser}:${message}:${new Date().toISOString()}`;
        if (displayedMessages.has(messageKey)) return;
        displayedMessages.add(messageKey);
    
        // Nachricht erstellen und anzeigen
        const now = new Date();
        const hours = now.getHours().toString().padStart(2, '0');
        const minutes = now.getMinutes().toString().padStart(2, '0');
        const seconds = now.getSeconds().toString().padStart(2, '0');
        const timeString = `${hours}:${minutes}:${seconds}`;
    
        const messageElement = document.createElement('div');
        messageElement.className = 'sent-message';
    
        const messageText = document.createElement('span');
        messageText.className = 'chattext';
        messageText.textContent = `${currentUser}: ${message}`;
    
        const messageTime = document.createElement('span');
        messageTime.className = 'chattext timestamp';
        messageTime.textContent = timeString;
    
        messageElement.appendChild(messageText);
        messageElement.appendChild(messageTime);
    
        sentMessagesContainer.appendChild(messageElement);
        sentMessagesContainer.scrollTop = sentMessagesContainer.scrollHeight;
    }
    
    function sendMessage(message) {
        const chatPartner = getChatpartner();
    
        const formData = new URLSearchParams();
        formData.append("msg", message);
        formData.append("to", chatPartner);
    
        fetch("chat.php", {
            method: "POST",
            body: formData,
        })
            .then(response => {
                if (response.ok) {
                    displaySentMessage(message);
                } else {
                    throw new Error(`Fehler beim Senden der Nachricht: ${response.status}`);
                }
            })
            .catch(error => {
                console.error("Fehler beim Senden der Nachricht:", error);
            });
    }
    
    function getChatpartner() {
        const url = new URL(window.location.href);
        const friend = url.searchParams.get("friend");
        if (!friend) {
            window.location.href = "friends.php";
        }
        return friend;
    }

    function updateChatHeader() {
        const chatPartner = getChatpartner();
        const headerElement = document.querySelector("h1");
        if (headerElement && chatPartner) {
            headerElement.textContent = `Chat with ${chatPartner}`;
        }
    }

    function loadMessages() {
        const chatPartner = getChatpartner();
    
        fetch(`ajax_load_messages.php?to=${encodeURIComponent(chatPartner)}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Fehler beim Laden der Nachrichten: ${response.status}`);
                }
                return response.json();
            })
            .then(messages => {
                displayMessages(messages);
            })
            .catch(error => {
                console.error("Fehler beim Laden der Nachrichten:", error);
            });
    }
    
    const displayedMessages = new Set();

function displayMessages(messages) {
    const messageContainer = document.getElementById("sent-messages-container");
    if (!messageContainer) return;

    messages.forEach(message => {

        const messageKey = `${message.from}:${message.msg}:${message.time}`;

        
        if (!displayedMessages.has(messageKey)) {
            displayedMessages.add(messageKey); 

            const messageElement = document.createElement("div");
            messageElement.className = "message";

            const fromElement = document.createElement("span");
            fromElement.className = "from";
            fromElement.textContent = `${message.from}:`;

            const msgElement = document.createElement("span");
            msgElement.className = "msg";
            msgElement.textContent = `"${message.msg}"`;

            const timeElement = document.createElement("span");
            timeElement.className = "time";
            timeElement.textContent = ` (${message.time})`;

            // Elemente zusammenfügen
            messageElement.appendChild(fromElement);
            messageElement.appendChild(msgElement);
            messageElement.appendChild(timeElement);

            // Nachricht hinzufügen
            messageContainer.appendChild(messageElement);
        }
    });

    // Automatisches Scrollen zum neuesten Eintrag
    messageContainer.scrollTop = messageContainer.scrollHeight;
}

    // Initialisierung der Chatfunktionalität
    function initializeChat() {
        updateChatHeader(); // Header aktualisieren
        loadMessages(); // Nachrichten laden

        // Sende-Event mit dem Formular verbinden
        const form = document.getElementById("message-form");
        if (form) {
            form.addEventListener("submit", handleFormSubmit);
        }
    }

    // Chat initialisieren, wenn die DOM geladen wurde
    document.addEventListener("DOMContentLoaded", initializeChat);
});