<?php
require("ajax_load_friends.php");

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html>

<head>
  <title>Friend list</title>
  <link rel="stylesheet" href="./style.css" />
  <script src="./friends.js" language="javascript" type="text/javascript" ></script>
</head>

<body>
  <h1 class="h1left">Friends</h1>
  <div class="navbar">
    <a href="logout.php"> <span>&lt; Logout</span></a> |
    <a href="settings.php"> Settings</a>
  </div>
  <hr />

  <div class="chatfield">
    <ul id="friendlist">
    </ul>
  </div>
  <hr>
  <div>
    <h2 class="h2left">New Requests</h2>

    <ol id="requestlist">
    </ol>
  </div>

  <input 
    placeholder="Add Friend to List" 
    name="friendRequestName" 
    id="friend-request-name" 
    list="friend-selector" 
    type ="text"
  >
  <datalist id="friend-selector"></datalist>
  <button type="button" class ="send-add-button" id="add-friend-button">Add</button>

  <hr>

</body>

</html>