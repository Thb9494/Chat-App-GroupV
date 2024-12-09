<!DOCTYPE html>
<html>

<head>
  <title>Friend list</title>
  <link rel="stylesheet" href="./style.css" />
  <script src="./friends.js" language="javascript" type="text/javascript" ></script>
  <?php require("start.php"); ?>
</head>

<body>
  <h1 class="h1left">Friends</h1>
  <div class="navbar">
    <!-- &lt is the sign for the "<" -> span changes the inline styling without 
            changing the representation of the, in this case, link
            &gt stands for ">" -->

    <a href="logout.html"> <span>&lt; Logout</span></a> |

    <!-- The pipe character is seprating the two links -->

    <a href="settings.html"> Settings</a>
  </div>

  <!-- hr is rendering a seperator line -->

  <hr />

  <div class="chatfield">
    <ul id="friendlist">
      <!-- The list of friends will be displayed here and is created by createFriendlist() -->
    </ul>
  </div>
  <hr>
  <div>
    <h2 class="h2left">New Requests</h2>

    <ol id="requestlist">
      <!-- <li>Friend request from <b>Track</b>
        <a href="unknownyet.txt"><button class="regular-button">Accept</button></a>
        <a href="unknownyet.txt"><button class="regular-button">Reject</button></a>
      </li> -->
    </ol>
  </div>



  <input placeholder="Add Friend to List" name="friendRequestName" id="friend-request-name" list="friend-selector" type ="text">
  <datalist id="friend-selector"></datalist>
  <button type="button" class ="send-add-button" id="add-friend-button">Add</button>

  <hr>

</body>

</html>