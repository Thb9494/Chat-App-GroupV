document.addEventListener("DOMContentLoaded", () => {
    const sendButton = document.querySelector(".send-add-button");

    const chatpartner = getChatpartner();
    const headerMessage = 'Chat with ' + chatpartner;

    document.getElementById("partner-name").textContent =  headerMessage;

    if (sendButton) {
        sendButton.addEventListener("click", () => {
            const message = document.querySelector(".chatinput").value;
            console.log("message:", message);
            sendMessage(message); // Call the function to send the message
        });
    }

    loadMessages(); // Call the function to load messages
    setInterval(loadMessages, 1000); // Reload messages every second
});

function getChatpartner() {
    const url = new URL(window.location.href);
    const queryParams = url.searchParams;
    const friendValue = queryParams.get("friend");
    return friendValue;
}

function loadMessages() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            let data = JSON.parse(xmlhttp.responseText);
            console.log(data);
            // Process the loaded messages here
        }
    };
    xmlhttp.open("GET", "https://online-lectures-cs.thi.de/chat/dummy/list-messages", true);
    // Add token, e.g., from Tom
    xmlhttp.setRequestHeader('Authorization', 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyIjoiVG9tIiwiaWF0IjoxNzMyNDU1NTgzfQ.g9x_MVT5ZGX-_hnZUcqr1Wlh2fe2OYgvrCTPXpR5tSY');
    xmlhttp.send();
}

function sendMessage(message) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            let data = JSON.parse(xmlhttp.responseText);
            console.log(data);
            // Process the sent message here
        }
    };
    xmlhttp.open("POST", "https://online-lectures-cs.thi.de/chat/dummy/send-message", true);
    // Add token, e.g., from Tom
    xmlhttp.setRequestHeader('Authorization', 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyIjoiVG9tIiwiaWF0IjoxNzMyNDU1NTgzfQ.g9x_MVT5ZGX-_hnZUcqr1Wlh2fe2OYgvrCTPXpR5tSY');
    xmlhttp.setRequestHeader('Content-Type', 'application/json');
    xmlhttp.send(JSON.stringify({ message: message }));
}
