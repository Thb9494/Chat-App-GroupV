<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <script src="chat.js"></script>

    <?php require("start.php"); 
    $user = new Model\User("Test");
    $json = json_encode($user);
    echo $json;"<br>";
    $jsonObject = json_decode($json);
    $newUser = Model\User::fromJson($jsonObject);
    var_dump($newUser);?>

</head>
<body>
    <h1 class="left">Chat with</h1>
    <a href="friends.php" class="leftL"> < Back </a> |
    <a href="profile.php" class="leftL"> Profile </a> |
    <a href="friends.php" class="leftL critical"> Remove Friend</a>
    <hr>
    <div>
        <div id="message-container">
            <!-- Messages will be inserted here -->
        </div>
        <div class="chat">
            <form>
                <input type="text" placeholder="Type your message...">
                <input type="button" value="Send" onclick="sendMessage(event)">
            </form>
        </div>
    </div>
</body>
</html>