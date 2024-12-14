document.addEventListener('DOMContentLoaded', function () {
    const registerForm = document.getElementById("registerForm");
    const userNameField = document.getElementById("userNameField");
    const passwordField = document.getElementById("passwordField");
    const confirmPasswordField = document.getElementById("confirmPasswordField");

    const userNameFieldError = document.getElementById("userNameFieldError");
    const passwordFieldError = document.getElementById("passwordFieldError");
    const confirmPasswordFieldError = document.getElementById("confirmPasswordFieldError");

    // Benutzername-Validierung mit AJAX
    userNameField.addEventListener("blur", function () {
        const username = userNameField.value.trim();
        if (username.length < 3) {
            userNameFieldError.textContent = "Der Benutzername muss mindestens 3 Zeichen lang sein.";
            userNameField.style.border = "2px solid red";
            return;
        }
        fetch(`ajax_check_user.php?username=${encodeURIComponent(username)}`)
            .then(response => {
                if (response.status === 409) {
                    userNameFieldError.textContent = "Der Benutzername ist bereits vergeben.";
                    userNameField.style.border = "2px solid red";
                } else if (response.status === 200) {
                    userNameFieldError.textContent = "";
                    userNameField.style.border = "2px solid green";
                } 
            })
            .catch(() => {
                userNameFieldError.textContent = "Netzwerkfehler bei der Überprüfung.";
                userNameField.style.border = "2px solid red";
            });
    });

    // Formular-Validierung vor Absenden
    registerForm.addEventListener("submit", function (event) {
        let isValid = true;

        // Benutzername überprüfen
        if (userNameField.value.trim().length < 3) {
            userNameFieldError.textContent = "Der Benutzername muss mindestens 3 Zeichen lang sein.";
            userNameField.style.border = "2px solid red";
            isValid = false;
        } else {
            userNameFieldError.textContent = "";
            userNameField.style.border = "2px solid green";
        }

        // Passwort überprüfen
        if (passwordField.value.length < 8) {
            passwordFieldError.textContent = "Das Passwort muss mindestens 8 Zeichen lang sein.";
            passwordField.style.border = "2px solid red";
            isValid = false;
        } else {
            passwordFieldError.textContent = "";
            passwordField.style.border = "2px solid green";
        }

        // Passwort-Wiederholung überprüfen
        if (passwordField.value !== confirmPasswordField.value) {
            confirmPasswordFieldError.textContent = "Die Passwörter stimmen nicht überein.";
            confirmPasswordField.style.border = "2px solid red";
            isValid = false;
        } else {
            confirmPasswordFieldError.textContent = "";
            confirmPasswordField.style.border = "2px solid green";
        }

        if (!isValid) {
            event.preventDefault();
        }
    });
});
