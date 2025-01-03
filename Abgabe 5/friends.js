async function getFriends() {
  try {
    const response = await fetch('ajax_load_friends.php');
    if (!response.ok) {
      throw new Error(`HTTP Error: ${response.status}`);
    }
    const data = await response.json();
    return data; // JSON-Daten zurückgeben
  } catch (error) {
    console.error('Error loading friends:', error);
    throw error; // Fehler weiterwerfen, falls nötig
  }
}

function createFriendlist(friends) {
  const friendlist = document.getElementById("friendlist");
  friendlist.innerHTML = ""; // Vorherige Einträge löschen

  friends.forEach(friend => {
    if (friend.status === "accepted") { // Nur akzeptierte Freunde anzeigen
      const li = document.createElement("li");
      li.classList.add("list-group-item")
      const a = document.createElement("a");
      a.setAttribute("href", "chat.php?friend=" + friend.username);
      a.textContent = friend.username;
      a.classList.add("text-dark", "text-decoration-none");
      li.appendChild(a);
      friendlist.appendChild(li);
    }
  });
}

function createRequestList(friends) {
  const requestlist = document.getElementById("requestlist");
  requestlist.innerHTML = ""; // Vorherige Einträge löschen

  friends.forEach(friend => {
    if (friend.status === "requested") { // Nur angefragte Freunde anzeigen
      var modal = new bootstrap.Modal(document.getElementById("requestModal"));
      const li = document.createElement("li");
      li.classList.add("list-group-item");
      li.textContent = friend.username;
      li.addEventListener("click", () => {
        const modalTitle = document.querySelector("#requestModal .modal-title b");
        modalTitle.textContent = friend.username; // Den Namen im Modal anzeigen
        modal.show(); // Modal anzeigen
        ;});

      const acceptButton = document.getElementById("acceptButton");
      acceptButton.addEventListener("click", () => {
        const params = new URLSearchParams({
            username: friend.username,
            action: "accept"
        });
        window.location.href = window.location.pathname + "?" + params.toString();
    });

      const rejectButton = document.getElementById("rejectButton");
      
      rejectButton.addEventListener("click", () => {
        const params = new URLSearchParams({
            username: friend.username,
            action: "reject"
        });
        window.location.href = window.location.pathname + "?" + params.toString();
    });

      
      requestlist.appendChild(li);
    }
  });
}


// Hauptlogik
async function main() {
  try {
    var friends = await getFriends();
    const acceptedFriends = friends.filter(friend => friend.status === "accepted");
    const requestedFriends = friends.filter(friend => friend.status === "requested");

    // Listen im DOM aktualisieren
    createFriendlist(acceptedFriends);
    createRequestList(requestedFriends);

    window.setInterval(async function () { // Aktualisierung der Freundesliste
      try {
        // Freunde neu abrufen
        const friends = await getFriends();
        const acceptedFriends = friends.filter(friend => friend.status === "accepted");
        const requestedFriends = friends.filter(friend => friend.status === "requested");

        // Listen im DOM aktualisieren
        createFriendlist(acceptedFriends);
        createRequestList(requestedFriends);
        console.log("Listen aktualisiert.");
      } catch (error) {
        console.error("Fehler beim Aktualisieren der Freundesliste:", error);
      }
    }, 1000);


  } catch (error) {
    console.error("Error during initialization:", error);
  }
}

// main
main();
