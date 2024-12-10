<!DOCTYPE html>
<hmtl>
  <head>
    <title>Chat</title>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="./style.css" />
    <script src="./registerJS.js " defer></script>

    <?php require("start.php"); 
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $username = trim($_POST['username']);
      $password = trim($_POST['password']);
      $confirmPassword = trim($_POST['confirmPassword']);
      $errors = [];
  
      // Überprüfen, ob der Benutzername nicht leer ist und mindestens 3 Zeichen hat
      if (empty($username) || strlen($username) < 3) {
          $errors[] = "Der Benutzername muss mindestens 3 Zeichen lang sein.";
      }
  
      // Überprüfen, ob der Benutzername nicht vergeben ist
      if (BackendService::isUsernameTaken($username)) {
            $errors[] = "Der Benutzername ist bereits vergeben.";
      }
  
      // Überprüfen, ob das Passwort nicht leer ist
      if (empty($password)) {
          $errors[] = "Das Passwort darf nicht leer sein.";
      }
  
      // Überprüfen, ob das Passwort mindestens 8 Zeichen hat
      if (strlen($password) < 8) {
          $errors[] = "Das Passwort muss mindestens 8 Zeichen lang sein.";
      }
  
      // Überprüfen, ob das Passwort mit der Wiederholung übereinstimmt
      if ($password !== $confirmPassword) {
          $errors[] = "Die Passwörter stimmen nicht überein.";
      }
  
      // Wenn keine Fehler vorhanden sind, registriere den Benutzer
      if (empty($errors)) {
        $result = BackendService::register($username, $password);
        if ($result) {
            $_SESSION['user'] = $username;
            header("Location: friends.php");
            exit();
        } else {
            $errors[] = "Registrierung fehlgeschlagen. Bitte versuchen Sie es erneut.";
        }
    }
  }
    ?>
  </head>
  <body>
    <img class="roundimg" src="../images/user.png" width="100" height="100" />
    <h1>Register yourself</h1>
    <div>
      <form id="registerForm" action="friends.php" onsubmit="validateFormFields()"> 
        <fieldset>
          <legend class="top-descriptor">Register</legend>
          <div class="labelandinput">
            <div>

              <label class="input-descriptor">Username</label>
              <input id="userNameField" placeholder="Username" /><br />
              <div id="userNameFieldError" class="errorMessage"></div>


              <label class="input-descriptor">Password</label>
              <input id="passwordField" type="password" placeholder="Password" /><br />
              <div id="passwordFieldError" class="errorMessage"></div>


              <label class="input-descriptor">Confirm Password</label>
              <input id="confirmPasswordField" type="password" placeholder="Confirm Password" /><br />
              <div id="confirmPasswordFieldError" class="errorMessage"></div>

              <?php
              if (!empty($errors)) {
                  echo '<div class="errorMessage">' . implode('<br>', $errors) . '</div>';
                }
              ?>

            </div>
          </div>

        </fieldset>
        <a href="./login.html"><button class="regular-button" type="button">Cancel</button></a>
        <button class="primary-action-button" id="createAccountButton" type="submit">Create Account</button>
      </form>
    </div>
  </body>
</hmtl>