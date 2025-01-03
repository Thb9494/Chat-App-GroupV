<?php
require "start.php";

if (!isset($_SESSION["user"])) {
  header("Location: login.php");
  exit();
}

// Accept or reject friend request
if (isset($_GET['username']) && isset($_GET['action'])) {
  $username = $_GET['username'];
  $action = $_GET['action'];
  if ($action == "accept") {
    $service->friendAccept($username);
  } else if ($action == "reject") {
    $service->friendDismiss($username);
  }
}

// Send friend request
if (isset($_GET['friendRequestName'])) {
  $friendRequestName = $_GET['friendRequestName'];
  $service->friendRequest(["username" => $friendRequestName]);
}

$users = $service->loadUsers();
$friends = $service->loadFriends();
$friendnames = array_map(function ($friend) {
  return $friend->getUsername();
}, $friends);
$loggedInUserName = $_SESSION['user'];

$filteredUser = array_diff($users, $friendnames, [$loggedInUserName]);
?>

<!DOCTYPE html>
<html>

<head>
  <title>Friend list</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
  <script src="./friends.js" language="javascript" type="text/javascript"></script>
</head>

<body class=" bg-light" style="height: 100vh">
<div class="container my-4 w-75">
  <h1 class="h1left">Friends</h1>

  <div class="btn-group w-30">
    <a href="logout.php" class=" btn btn-secondary" type="button"> <span>&lt; Logout</span></a>
    <a href="settings.php" class="btn btn-secondary" type="button"> Settings</a>
  </div>
  <hr/>

  <div>
    <ul id="friendlist" class="list-group">
      <!-- Liste dynamisch generiert -->
    </ul>
  </div>
  
  <hr>

  <div>
    <h2 class="h2left">New Requests</h2>
    <ol id="requestlist" class="list-group">
      <!-- Liste dynamisch generiert -->
    </ol>
  </div>

  <div class="modal" tabindex="-1" role="dialog" id="requestModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Friend Request from <b></b></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeModal()"></button>
      </div>
      <div class="modal-body" id="modalName">
        <p>Accept request?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="acceptButton">Accept</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="rejectButton">Reject</button>
      </div>
    </div>
  </div>
</div>

<div class="container my-4 w-120">
  <form action="" method="GET">
    <!-- input-group Container für das Input-Feld und den Button -->
    <div class="input-group w-100">
      <!-- Das Input-Feld für die Freundesanfrage -->
      <input type="text" placeholder="Add Friend to List" name="friendRequestName" id="friend-request-name" list="friend-selector" class="form-control">
      
      <!-- Datalist für Vorschläge -->
      <datalist id="friend-selector">
        <?php foreach ($filteredUser as $user): ?>
          <option value="<?= $user ?>">
        <?php endforeach; ?>
      </datalist>

      <!-- Der Button zum Absenden der Anfrage -->
      <button type="submit" class="btn btn-primary">Add</button>
    </div>
  </form>
</div>

  
</div>

</body>

</html>