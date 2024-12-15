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
  <link rel="stylesheet" href="./style.css" />
  <script src="./friends.js" language="javascript" type="text/javascript"></script>
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
      <!-- Liste dynamisch generiert -->
    </ul>
  </div>
  <hr>
  <div>
    <h2 class="h2left">New Requests</h2>
    <ol id="requestlist">
      <!-- Liste dynamisch generiert -->
    </ol>
  </div>


  <form action="" method="GET">
    <input placeholder="Add Friend to List" name="friendRequestName" id="friend-request-name" list="friend-selector">
    <datalist id="friend-selector">
      <?php foreach ($filteredUser as $user): ?>
        <option value="<?= $user ?>">
      <?php endforeach; ?>
    </datalist>
    <button type="submit">Add</button>
  </form>

  <hr>

</body>

</html>