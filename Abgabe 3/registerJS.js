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
        if (xmlhttp.readyState == 4) {                  //Anfrage ist abschlossen und die Antwort steht zur Verfügung
            if(xmlhttp.status == 204) {                 //Anfrage erfolgreich, aber kein Inhalt ->Nutzername steht nicht zur Verfügung
                //userNameValidationError.textContent = "Der Nutzername existiert bereits";
                userNameValidation.style.border = "2px solid red";
                validation = false;
            } else if(xmlhttp.status == 404) {          //Nutzername nicht gefunden -> Nutzername steht zur Verfügung
                //userNameValidationError.textContent = "";
                userNameValidation.style.border = "2px solid green";
            }
        }
        };
        xmlhttp.open("GET" ,"https://online-lectures-cs.thi.de/chat/c49d4fa0-6113-4b89-ac33-ebda6d4a5e96/user/" + userNameValidation.value, true); //Anfrage wird erstellt 
        xmlhttp.send(); //Anfrage wird gesendet
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
        confirmPasswordValidation.style.border = "2px solid green"; //Funktioniert, sollte aber besser in CSS sein

    }

    //Wenn alles richtig ist, wird die nächste Seite aufgerufen
    if (validation == true) {

        document.getElementById("registerForm").submit(); //Formular abschicken, von element suchen getElemtById -> submit triggern

    }
}