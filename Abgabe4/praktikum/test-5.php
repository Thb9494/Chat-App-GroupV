<?php
require("../start.php");
$service = new Utils\BackendService(CHAT_SERVER_URL, CHAT_SERVER_ID);

// Test-Daten
$testUser = new Model\User("Peter");
$messageObject = (object) ["msg" => "Hallo!", "to" => "Jerry"];
$friendRequestObject = ["username" => "Jerry"];

// Aufruf der Methoden
$loginResult = $service->login("Tom", "12345678");
$registerResult = $service->register("Müller", "12345678");
$loadUserResult = $service->loadUser("Tom");
$saveUserResult = $service->saveUser($testUser);
$loadMessagesResult = $service->loadMessages("Jerry");
$loadFriendsResult = $service->loadFriends();
$loadUsersResult = $service->loadUsers();
$sendMessageResult = $service->sendMessage($messageObject);
$friendRequestResult = $service->friendRequest($friendRequestObject);
$friendAcceptResult = $service->friendAccept("Jerry");
$friendDismissResult = $service->friendDismiss("Jerry");
$removeFriendResult = $service->removeFriend("Jerry");
$userExistsResult = $service->userExists("Tom");
$getUnreadResult = $service->getUnread();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Backend Service Test</title>
</head>
<body>
    <h1>Backend Service Test Results</h1>
    
    <p>
        <strong>login("Tom", "12345678"):</strong> 
        <?php var_dump($loginResult); ?>
    </p>
    <p>
        <strong>register("Thessa", "12345678"):</strong> 
        <?php var_dump($registerResult); ?>
    </p>
    <p>
        <strong>loadUser("Tom"):</strong> 
        <?php var_dump($loadUserResult); ?>
    </p>
    <p>
        <strong>saveUser($testUser):</strong> 
        <?php var_dump($saveUserResult); ?>
    </p>
    <p>
        <strong>loadMessages("Jerry"):</strong> 
        <?php var_dump($loadMessagesResult); ?>
    </p>
    <p>
        <strong>loadFriends():</strong> 
        <?php var_dump($loadFriendsResult); ?>
    </p>
    <p>
        <strong>loadUsers():</strong> 
        <?php var_dump($loadUsersResult); ?>
    </p>
    <p>
        <strong>sendMessage($messageObject):</strong> 
        <?php var_dump($sendMessageResult); ?>
    </p>
    <p>
        <strong>friendRequest($friendRequestObject):</strong> 
        <?php var_dump($friendRequestResult); ?>
    </p>
    <p>
        <strong>friendAccept("Jerry"):</strong> 
        <?php var_dump($friendAcceptResult); ?>
    </p>
    <p>
        <strong>friendDismiss("Jerry"):</strong> 
        <?php var_dump($friendDismissResult); ?>
    </p>
    <p>
        <strong>removeFriend("Jerry"):</strong> 
        <?php var_dump($removeFriendResult); ?>
    </p>
    <p>
        <strong>userExists("Tom"):</strong> 
        <?php var_dump($userExistsResult); ?>
    </p>
    <p>
        <strong>getUnread():</strong> 
        <?php var_dump($getUnreadResult); ?>
    </p>
</body>
</html>