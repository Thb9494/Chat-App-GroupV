<?php
require("start.php");

if(isset($_SESSION["user"])) {
    header("Location: friends.php");
    exit();
}

// Nutzereingaben aus dem Formular holen
$username = $_POST["username"] ?? "";
$password = $_POST["password"] ?? "";

// BackendService-Instanz erstellen
$service = new Utils\BackendService(CHAT_SERVER_URL, CHAT_SERVER_ID);

if ($service->login($username, $password)) {
    $_SESSION["user"] = $username;
    header("Location: friends.php");
    exit(); // Sicherstellen, dass kein weiterer Code ausgeführt wird
}

?>

<!DOCTYPE html>

</html>

<head>
    <!-- Adding a title to the web page -->
    <title>Please Sign in</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<body>
    <img class="roundimg" src="../images/chat.png" width="100" height="100" />
    <h1>Please sign in</h1>
    <form action="" method="post">
        <fieldset>
            <legend class="top-descriptor">Login</legend>
            <div>
                <div>
                    <label class="input-descriptor">Username</label>
                    <input placeholder="Username" name="username" />
                </div>
                <div>
                    <label class="input-descriptor">Password</label>
                    <input placeholder="Password" name="password" type="password"/>
                </div>
            </div>
        </fieldset>
        <a href="./register.php"><button class="regular-button" type="button">Register</button></a>
        <button class="primary-action-button" type="submit" value="Login">Login</button>
    </form>
</body>

</html>