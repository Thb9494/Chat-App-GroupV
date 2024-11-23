// register

let createAccountButton = document.getElementById("createAccountButton");
createAccountButton.addEventListener("click", validateFormFields);

function validateFormFields(event) {

    event.preventDefault();

    //Variablen für die einzelnen Felder
    let userNameValidation = document.getElementById("userNameField");
    let passwordValidation = document.getElementById("passwordField");
    let confirmPasswordValidation = document.getElementById("confirmPasswordField");
    //Varible für die Valiedierung
    let validation = true;
    //Variable für die Fehlertexte
    let userNameValidationError = document.getElementById("userNameFieldError");
    let passwordValidationError = document.getElementById("passwordFieldError");
    let confirmPasswordValidationError = document.getElementById("confirmPasswordFieldError");

    //Nutzernamen überprüfen
    if (userNameValidation.value.length < 3 || userNameValidation.value == "") {
        userNameValidationError.textContent = "Der Nutzername muss mindestens 3 Zeichen lang sein";
        userNameValidation.style.border = "2px solid red";
        validation = false;
    }
    else if(userNameValidation.value.length >= 3){
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4) {
            if(xmlhttp.status == 204) {
                console.log("Exists");
                userNameValidationError.textContent = "Der Nutzername existiert bereits";
                userNameValidation.style.border = "2px solid red";
                validation = false;
            } else if(xmlhttp.status == 404) {
                console.log("Does not exist");
                userNameValidation.style.border = "2px solid green";
            }
        }
        };
        xmlhttp.open("GET", "https://online-lectures-cs.thi.de/chat/3bec886e-beae-4d6b-bfcd-f9389724c5e5/user/Tom", true);
        xmlhttp.send();
    }
    else{
        userNameValidation.style.border = "2px solid green";
    }

    //Passwort überprüfen
    if (passwordValidation.value.length < 8 || passwordValidation.value == "") {
        passwordValidationError.textContent = "Das Passwort muss mindestens 8 Zeichen lang sein";
        passwordValidation.style.border = "2px solid red";
        validation = false;
    }
    else {
        passwordValidation.style.border = "2px solid green";
    }

    //Passwort bestätigen überprüfen
    if (passwordValidation.textContent != confirmPasswordValidation.textContent || confirmPasswordValidation.value == "") {
        confirmPasswordValidationError.textContent = "Die Passwörter stimmen nicht überein";
        confirmPasswordValidation.style.border = "2px solid red";
        validation = false;
    }
    else {
        confirmPasswordValidation.style.border = "2px solid green";

    }

    //Wenn alles richtig ist, wird die nächste Seite aufgerufen
    if (validation == true) {
        window.location.href = "friends.html";
    }
}


/*
    var userNameValidation = document.forms["register-form"]["username"].value; //vielleicht lieber elemente mit getElementById holen
    if (userNameValidation.lenght < 3) { //lieber nach Länge fragen, nicht nach dem Nutzernamen
      alert("Der Name muss mindestens 3 Zeichen lang sein"); //z.B. mit DOM-APi das Element holen und Stileigenschaften ändern um visuell dazustellen, ob man es richtig hat
      return false;
    }
  
    //es fehlt noch UserExist (über Dokumentation)
    //DOM-Strukutzr Anpassung fehlt noch
*/