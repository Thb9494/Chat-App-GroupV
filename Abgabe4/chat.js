// Backend-URLs für Nachrichten laden und senden
const loadMessagesUrl = "ajax_load_messages.php";
const sendMessageUrl = "ajax_send_message.php";

// Chatpartner aus der URL auslesen
function getChatpartner() {
    const url = new URL(window.location.href);
    const friend = url.searchParams.get("friend"); // Parameter "friend"
    if (!friend) {
        alert("Kein Chatpartner ausgewählt! Bitte wähle einen Freund.");
        window.location.href = "friends.php"; // Redirect zu Freundesliste
    }
    return friend;
}

// Chat-Header aktualisieren
function updateChatHeader() {
    const chatPartner = getChatpartner();
    const headerElement = document.querySelector("h1");
    if (headerElement && chatPartner) {
        headerElement.textContent = `Chat mit ${chatPartner}`;
    }
}

// Nachrichten laden und im Chat anzeigen
function loadMessages() {
    const chatPartner = getChatpartner();

    fetch(`${loadMessagesUrl}?to=${encodeURIComponent(chatPartner)}`)
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

// Nachrichten im Container anzeigen
function displayMessages(messages) {
    const messageContainer = document.getElementById("message-container");
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

// Funktion zum Anzeigen einer gesendeten Nachricht im UI
function displaySentMessage(message) {
    const sentMessagesContainer = document.getElementById("sent-messages-container");
    if (!sentMessagesContainer) return;


    // Aktuelle Zeit formatieren
    const now = new Date();
    const hours = now.getHours().toString().padStart(2, '0');
    const minutes = now.getMinutes().toString().padStart(2, '0');
    const seconds = now.getSeconds().toString().padStart(2, '0');
    const timeString = `${hours}:${minutes}:${seconds}`;

    // Neue Nachricht erstellen
    const messageElement = document.createElement("div");
    messageElement.className = "sent-message";

    const messageText = document.createElement("span");
    messageText.className = "chattext";
    messageText.textContent = `${currentUser}: ${message}`;

    const messageTime = document.createElement("span");
    messageTime.className = "chattext timestamp";
    messageTime.textContent = timeString;

    messageElement.appendChild(messageText);
    messageElement.appendChild(messageTime);


    // Nachricht zum Container hinzufügen
    sentMessagesContainer.appendChild(messageElement);

    // Optional: Automatisch zum neuesten Eintrag scrollen
    sentMessagesContainer.scrollTop = sentMessagesContainer.scrollHeight;
}

// Nachricht senden
function sendMessage(event) {
    event.preventDefault(); // Verhindert das Standard-Formularverhalten

    const messageInput = document.getElementById("message-input");
    const message = messageInput.value.trim();
    const chatPartner = getChatpartner();

    if (!message) {
        alert("Bitte gib eine Nachricht ein.");
        return;
    }

    // Eingabefeld direkt leeren
    messageInput.value = "";

    // Zeige die gesendete Nachricht sofort im UI an
    displaySentMessage(message);

    const formData = new URLSearchParams();
    formData.append("to", chatPartner);
    formData.append("msg", message);

    // Nachricht an den Server senden
    fetch(sendMessageUrl, {
        method: "POST",
        body: formData,
    })
        .then(response => {
            if (response.ok) {
                messageInput.value = ""; // Eingabefeld leeren
                loadMessages(); // Nachrichtenliste aktualisieren
            } else {
                throw new Error(`Fehler beim Senden der Nachricht: ${response.status}`);
            }
        })
        .catch(error => {
            console.error("Fehler beim Senden der Nachricht:", error);
        });
}

// Initialisierung der Chatfunktionalität
function initializeChat() {
    updateChatHeader(); // Header aktualisieren
    loadMessages(); // Nachrichten laden

    // Alle 3 Sekunden Nachrichten aktualisieren
    setInterval(loadMessages, 3000);

    // Sende-Event mit dem Formular verbinden
    const form = document.getElementById("chat-form");
    if (form) {
        form.addEventListener("submit", sendMessage);
    }
}

// Chat initialisieren, wenn die DOM geladen wurde
document.addEventListener("DOMContentLoaded", initializeChat);
