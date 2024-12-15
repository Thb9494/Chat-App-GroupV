<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link rel="stylesheet" href="./style.css" />
    <script src="./registerJS.js" defer></script>

    <?php
    require("start.php");

$username = $password = $confirmPassword = "";
$usernameError = $passwordError = $confirmPasswordError = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $confirmPassword = trim($_POST['confirmPassword'] ?? '');

        // Benutzername validieren
        if (empty($username) || strlen($username) < 3) {
            $usernameError = "Der Benutzername muss mindestens 3 Zeichen lang sein.";
        } elseif (BackendService::isUsernameTaken($username)) {
            $usernameError = "Der Benutzername ist bereits vergeben.";
        }

        // Passwort validieren
        if (empty($password) || strlen($password) < 8) {
            $passwordError = "Das Passwort muss mindestens 8 Zeichen lang sein.";
        }

    // Passwort-Wiederholung prüfen
    if ($password !== $confirmPassword) {
        $confirmPasswordError = "Die Passwörter stimmen nicht überein.";
    }

        // Registrierung durchführen, wenn keine Fehler vorhanden sind
        if (empty($usernameError) && empty($passwordError) && empty($confirmPasswordError)) {
            if (BackendService::register($username, $password)) {
                session_start();
                $_SESSION['user'] = $username;
                header("Location: friends.php");
                exit();
            } else {
                $usernameError = "Registrierung fehlgeschlagen.";
            }
        }
    }
    ?>
</head>
<body>
    <img class="roundimg" src="../images/user.png" width="100" height="100" />
    <h1>Register yourself</h1>
    <div>
      <form id="registerForm" method="POST" action="">
        <fieldset>
          <legend class="top-descriptor">Register</legend>
          <div class="labelandinput">
            <div>
              <label class="input-descriptor">Username</label>
              <input name="username" id="userNameField" placeholder="Username" value="<?php echo htmlspecialchars($username); ?>"/><br />
              <div id="userNameFieldError" class="errorMessage"><?php echo $usernameError; ?></div>

              <label class="input-descriptor">Password</label>
              <input name="password" id="passwordField" type="password" placeholder="Password" /><br />
              <div id="passwordFieldError" class="errorMessage"><?php echo $passwordError; ?></div>

              <label class="input-descriptor">Confirm Password</label>
              <input name="confirmPassword" id="confirmPasswordField" type="password" placeholder="Confirm Password" /><br />
              <div id="confirmPasswordFieldError" class="errorMessage"><?php echo $confirmPasswordError; ?></div>
            </div>
          </div>
        </fieldset>
        <a href="./login.html"><button class="regular-button" type="button">Cancel</button></a>
        <button class="primary-action-button" id="createAccountButton" type="submit">Create Account</button>
      </form>
    </div>
  </body>
</html>