document.addEventListener('DOMContentLoaded', function() {
    const messageForm = document.getElementById('message-form');
    const messageInput = document.getElementById('message-input');
    const sentMessagesContainer = document.getElementById('sent-messages-container');

    // Entfernen Sie alle vorherigen Event-Listener, um sicherzustellen, dass der Event-Listener nur einmal hinzugefügt wird
    messageForm.removeEventListener('submit', handleFormSubmit);
    messageForm.addEventListener('submit', handleFormSubmit);

    function handleFormSubmit(event) {
        event.preventDefault(); // Verhindert das Standard-Formularverhalten

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

        // Aktuelle Zeit formatieren
        const now = new Date();
        const hours = now.getHours().toString().padStart(2, '0');
        const minutes = now.getMinutes().toString().padStart(2, '0');
        const seconds = now.getSeconds().toString().padStart(2, '0');
        const timeString = `${hours}:${minutes}:${seconds}`;

        // Neue Nachricht erstellen
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

        // Nachricht zum Container hinzufügen
        sentMessagesContainer.appendChild(messageElement);

        // Optional: Automatisch zum neuesten Eintrag scrollen
        sentMessagesContainer.scrollTop = sentMessagesContainer.scrollHeight;
    }

    function sendMessage(message) {
        const chatPartner = getChatpartner();

        // URL-kodierte Formulardaten für die Nachricht
        const formData = new URLSearchParams();
        formData.append("msg", message); // Nachricht
        formData.append("to", chatPartner); // Empfänger

        // Nachricht an den Server senden
        fetch("chat.php", {
            method: "POST",
            body: formData, // Formulardaten senden
        })
            .then(response => {
                if (response.ok) {
                    displaySentMessage(message); // Zeige die gesendete Nachricht sofort im UI an
                    loadMessages(); // Nachrichtenliste aktualisieren
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
        const friend = url.searchParams.get("friend"); // Parameter "friend"
        if (!friend) {
            window.location.href = "friends.php"; // Redirect zu Freundesliste
        }
        return friend;
    }

    function updateChatHeader() {
        const chatPartner = getChatpartner();
        const headerElement = document.querySelector("h1");
        if (headerElement && chatPartner) {
            headerElement.textContent = `Chat mit ${chatPartner}`;
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

    function displayMessages(messages) {
        const messageContainer = document.getElementById("sent-messages-container");
        if (!messageContainer) return;

        // Bestehende Nachrichten entfernen
        messageContainer.innerHTML = "";

        // Neue Nachrichten hinzufügen
        messages.forEach(message => {
            const messageElement = document.createElement("div");
            messageElement.className = "message";
            messageElement.textContent = `${message.from}: "${message.msg}"`;
            messageContainer.appendChild(messageElement);
        });

        // Automatisches Scrollen zum neuesten Eintrag
        messageContainer.scrollTop = messageContainer.scrollHeight;
    }

    // Initialisierung der Chatfunktionalität
    function initializeChat() {
        updateChatHeader(); // Header aktualisieren
        loadMessages(); // Nachrichten laden

        // Alle 3 Sekunden Nachrichten aktualisieren
        setInterval(loadMessages, 3000);

        // Sende-Event mit dem Formular verbinden
        const form = document.getElementById("message-form");
        if (form) {
            form.addEventListener("submit", handleFormSubmit);
        }
    }

    // Chat initialisieren, wenn die DOM geladen wurde
    document.addEventListener("DOMContentLoaded", initializeChat);
});