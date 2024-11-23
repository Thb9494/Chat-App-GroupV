// TOM TOKEN = eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyIjoiVG9tIiwiaWF0IjoxNzMyMDIxNDYwfQ.3g4DxMDq6WiV6GBwUU8Hz1ho4UJfcS0ZfHXlTxHiOH8
// JERRY TOKEN = eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyIjoiSmVycnkiLCJpYXQiOjE3MzIwMjE0NjB9.X42SAGOFXKjYqAdxYZXV4f0K3xcmDkvN6xVhbN5aOC4

window.backendUrl = "https://online-lectures-cs.thi.de/chat/62eb1b2e-d66c-4a9b-b172-5942717d0bac";
window.token = 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyIjoiVG9tIiwiaWF0IjoxNzMyMDIxNDYwfQ.3g4DxMDq6WiV6GBwUU8Hz1ho4UJfcS0ZfHXlTxHiOH8';

function getUsers() {
  return new Promise((resolve) => {
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
      if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        let data = JSON.parse(xmlhttp.responseText);
        resolve(data);
      }
    };
    xmlhttp.open("GET", backendUrl + "/user", true);
    xmlhttp.setRequestHeader('Authorization', token);
    xmlhttp.send();
  })

}

async function getFriends() {
  return new Promise((resolve) => {
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
      if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        let data = JSON.parse(xmlhttp.responseText);
        resolve(data);
      }
    };
    xmlhttp.open("GET", backendUrl + "/friend", true);
    xmlhttp.setRequestHeader('Content-type', 'application/json');
    xmlhttp.setRequestHeader('Authorization', token);
    xmlhttp.send();
  });
}

function postFriends(userName) {
  let xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function () {
    if (xmlhttp.readyState == 4 && xmlhttp.status == 204) {
      console.log("Requested...");
    }
  };
  xmlhttp.open("POST", backendUrl + "/friend", true);
  xmlhttp.setRequestHeader('Content-type', 'application/json');
  xmlhttp.setRequestHeader('Authorization', token);
  let data = {
    username: userName
  };
  let jsonString = JSON.stringify(data);
  xmlhttp.send(jsonString);
}

function createDatalist(users) {
  const datalist = document.getElementById("friend-selector");
  datalist.innerHTML = ""; // Vorherige Einträge löschen

  users.forEach(user => {
    const option = document.createElement("option");
    option.value = user;
    datalist.appendChild(option);
    // <option value="username"></option>
  });
}

function createFriendlist(friends) {
  const friendlist = document.getElementById("friendlist");
  friendlist.innerHTML = ""; // Vorherige Einträge löschen

  friends.forEach(friend => {
    if (friend.status === "accepted") { // Nur akzeptierte Freunde anzeigen
      const li = document.createElement("li");
      const a = document.createElement("a");
      a.setAttribute("href", "chat.html?friend=" + friend.username);
      a.textContent = friend.username;
      li.appendChild(a);
      friendlist.appendChild(li);
      // <li>
      //  <a href="chat.html">Tom</a>
      // </li> 
    }
    console.log("friend:", friend);
  });
}

function createRequestList(friends) {
  const requestlist = document.getElementById("requestlist");
  requestlist.innerHTML = ""; // Vorherige Einträge löschen

  friends.forEach(friend => {
    if (friend.status === "requested") { // Nur angefragte Freunde anzeigen
      const li = document.createElement("li");
      li.textContent = friend.username;

      const acceptButton = document.createElement("button");
      acceptButton.textContent = "Accept";
      acceptButton.addEventListener("click", () => {
      });

      const rejectButton = document.createElement("button");
      rejectButton.textContent = "Reject";
      rejectButton.addEventListener("click", () => {
      });

      li.appendChild(acceptButton);
      li.appendChild(rejectButton);
      requestlist.appendChild(li);


    }
    console.log("friend:", friend);
  });
}

function onClickAddFriend(filterUsers) {
  document.getElementById("add-friend-button").addEventListener("click", () => {
    const input = document.getElementById("friend-request-name");
    const friendRequestName = input.value;

    if (friendRequestName === "") {
      alert("Bitte geben Sie einen gültigen Benutzernamen ein.");
      return;
    }

    if (!filterUsers.includes(friendRequestName)) {
      alert("Dieser Benutzer hat bereits eine Freundschaftsanfrage erhalten oder ist bereits Ihr Freund.");
      return;
    }

    postFriends(friendRequestName); // Freund hinzufügen
    alert(`Freundesanfrage an ${friendRequestName} gesendet!`);
  });
}

const loggedInUser = "Tom"; // Aktuell eingeloggter Benutzer



// Hauptlogik
async function main() {
  try {

    var friends = await getFriends(); // object
    var acceptedFriends = friends.filter(friend => friend.status === "accepted");
    var requestedFriends = friends.filter(friend => friend.status === "requested");

    var users = await getUsers();
    var friendUsernames = friends.map(friend => friend.username); //string[]

    var filteredUsers = users.filter(user =>
      user !== loggedInUser // ohne eingeloggten Benutzer
      && !friendUsernames.includes(user) // ohne bereits hinzugefügte/angefragte Freunde
    );

    createFriendlist(friends);
    createDatalist(filteredUsers);
    createRequestList(friends);
    onClickAddFriend(filteredUsers);


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

// register-Logik

let createAccountButton = document.getElementById("createAccountButton");
createAccountButton.addEventListener("click", validateFormFields);

function validateFormFields(event) {

    event.preventDefault();

    //Variablen für die einzelnen Felder
    let userNameValidation = document.getElementById("userNameField");
    let passwordValidation = document.getElementById("passwordField");
    let confirmPasswordValidation = document.getElementById("confirmPasswordField");

    //Varible für die letzliche Valiedierung
    let validation = true;

    //Variable für die Fehlertexte
    //let userNameValidationError = document.getElementById("userNameFieldError");
    //let passwordValidationError = document.getElementById("passwordFieldError");
    //let confirmPasswordValidationError = document.getElementById("confirmPasswordFieldError");

    //Nutzernamen überprüfen
    if (userNameValidation.value.length < 3 || userNameValidation.value == "") {
        //userNameValidationError.textContent = "Der Nutzername muss mindestens 3 Zeichen lang sein";
        userNameValidation.style.border = "2px solid red";
        validation = false;
    }
    else if(userNameValidation.value.length >= 3){

        const xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4) {
            if(xmlhttp.status == 204) {
                //userNameValidationError.textContent = "Der Nutzername existiert bereits";
                userNameValidation.style.border = "2px solid red";
                validation = false;
            } else if(xmlhttp.status == 404) {
                //userNameValidationError.textContent = "";
                userNameValidation.style.border = "2px solid green";
            }
        }
        };
        xmlhttp.open("GET" ,"https://online-lectures-cs.thi.de/chat/c49d4fa0-6113-4b89-ac33-ebda6d4a5e96/user/" + userNameValidation.value, false);
        xmlhttp.send();
    }

    //Passwort überprüfen
    if (passwordValidation.value.length < 8 || passwordValidation.value == "") {
        //passwordValidationError.textContent = "Das Passwort muss mindestens 8 Zeichen lang sein";
        passwordValidation.style.border = "2px solid red";
        validation = false;
    }
    else {
        //passwordValidationError.textContent = "";
        passwordValidation.style.border = "2px solid green";
    }

    //Passwort bestätigen überprüfen
    if (passwordValidation.value != confirmPasswordValidation.value) {
        //confirmPasswordValidationError.textContent = "Die Passwörter stimmen nicht überein";
        confirmPasswordValidation.style.border = "2px solid red";
        validation = false;
    }
    else if(confirmPasswordValidation.value == "" || confirmPasswordValidation.value.length < 8){
        confirmPasswordValidation.style.border = "2px solid red";
        validation = false;
    }
    else {
        //confirmPasswordValidationError.textContent = "";
        confirmPasswordValidation.style.border = "2px solid green";

    }

    //Wenn alles richtig ist, wird die nächste Seite aufgerufen
    if (validation == true) {
        window.location.href = "friends.html";
    }
}

// main
main();


