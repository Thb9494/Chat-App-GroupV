<!DOCTYPE html>
<hmtl>
  <head>
    <title>Chat</title>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="./style.css" />
    <script src="./registerJS.js " defer></script>
    <?php require("start.php"); ?>
  </head>
  <body>
    <img class="roundimg" src="../images/user.png" width="100" height="100" />
    <h1>Register yourself</h1>
    <div>
      <form id="registerForm" action="friends.html" onsubmit="validateFormFields()"> 
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
            </div>
          </div>

        </fieldset>
        <a href="./login.html"><button class="regular-button" type="button">Cancel</button></a>
        <button class="primary-action-button" id="createAccountButton" type="submit">Create Account</button>
      </form>
    </div>
  </body>
</hmtl>