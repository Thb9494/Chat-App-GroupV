
document.addEventListener('DOMContentLoaded', function() {
    let createAccountButton = document.getElementById("createAccountButton");
    let userNameField = document.getElementById("userNameField");
    let passwordField = document.getElementById("passwordField");
    let confirmPasswordField = document.getElementById("confirmPasswordField");

    let userNameError = document.getElementById("userNameFieldError");
    let passwordError = document.getElementById("passwordFieldError");
    let confirmPasswordError = document.getElementById("confirmPasswordFieldError");

    // Initialer Check: Zeige PHP-Fehlermeldungen
    if (userNameError.textContent.trim() !== "") {
        userNameField.style.border = "2px solid red";
    }
    if (passwordError.textContent.trim() !== "") {
        passwordField.style.border = "2px solid red";
    }
    if (confirmPasswordError.textContent.trim() !== "") {
        confirmPasswordField.style.border = "2px solid red";
    }

    document.getElementById("registerForm").addEventListener("submit", validateFormFields);

    function validateFormFields(event) {
        // Alle Fehlermeldungen zunächst zurücksetzen
        userNameError.textContent = "";
        passwordError.textContent = "";
        confirmPasswordError.textContent = "";
    
        userNameField.style.border = "";
        passwordField.style.border = "";
        confirmPasswordField.style.border = "";
    
        let validation = true;
    
        // Nutzernamen prüfen
        if (userNameField.value.length < 3 || userNameField.value === "") {
            userNameField.style.border = "2px solid red";
            userNameError.textContent = "Der Nutzername muss mindestens 3 Zeichen lang sein.";
            validation = false;
        } else {
            userNameField.style.border = "2px solid green";
        }
    
        // Passwort prüfen
        if (passwordField.value.length < 8 || passwordField.value === "") {
            passwordField.style.border = "2px solid red";
            passwordError.textContent = "Das Passwort muss mindestens 8 Zeichen lang sein.";
            validation = false;
        } else {
            passwordField.style.border = "2px solid green";
        }
    
        // Passwort-Bestätigung prüfen
        if (passwordField.value !== confirmPasswordField.value || 
            confirmPasswordField.value === "" || 
            confirmPasswordField.value.length < 8) {
            confirmPasswordField.style.border = "2px solid red";
            confirmPasswordError.textContent = "Die Passwörter stimmen nicht überein.";
            validation = false;
        } else {
            confirmPasswordField.style.border = "2px solid green";
        }
    
        // Wenn keine Fehler, AJAX-Aufruf zur Benutzername-Überprüfung
        if (validation) {
            event.preventDefault(); // Verhindert das sofortige Absenden des Formulars
            const xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4) {
                    if (xmlhttp.status == 204) {
                        // Benutzername existiert bereits
                        userNameField.style.border = "2px solid red";
                        userNameError.textContent = "Der Nutzername ist bereits vergeben.";
                        validation = false;
                    } else if (xmlhttp.status == 404) {
                        // Benutzername ist verfügbar
                        userNameField.style.border = "2px solid green";
                        document.getElementById("registerForm").submit(); // Formular absenden, wenn keine Fehler
                    }
                }
            };
            xmlhttp.open("GET", "ajax_check_user.php?user=" + encodeURIComponent(userNameField.value), true);
            xmlhttp.send();
        } else {
            event.preventDefault(); // Verhindert Formularabsendung bei Validierungsfehlern
        }
    }
    
});