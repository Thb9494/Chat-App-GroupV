// register-Logik
document.addEventListener('DOMContentLoaded', function() {

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
    else {
        fetch(`ajax_check_user.php?username=${encodeURIComponent(userNameValidation.value)}`)
                .then(response => {
                    if (response.status === 409) {
                        userNameValidationError.textContent = "Der Benutzername ist bereits vergeben.";
                        userNameValidation.style.border = "2px solid red";
                        validation = false;
                    } else if (response.status === 200) {
                        userNameValidationError.textContent = "";
                        userNameValidation.style.border = "2px solid green";
                    } else {
                        userNameValidationError.textContent = "Fehler bei der Überprüfung des Benutzernamens.";
                        userNameValidation.style.border = "2px solid red";
                        validation = false;
                    }
                })
                .catch(error => {
                    userNameValidationError.textContent = "Fehler bei der Überprüfung des Benutzernamens.";
                    userNameValidation.style.border = "2px solid red";
                    validation = false;
                });
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
 });