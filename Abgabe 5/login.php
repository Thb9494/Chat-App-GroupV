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

<body class="d-flex justify-content-center " style="height: 100vh; background-color: #f1f1f1;">

<div class ="text-center mt-5">
    <img class="rounded-circle mb-4" src="../images/chat.png" width="100" height="100" />
    
    <form class="border p-4 rounded" action="" method="post" style="background-color: white">
    <h4>Please sign in</h4>
            
            <div>
                <div class ="mb-3">
                    
                    <input type="text" placeholder="Username" name="username" class="form-control"/>
                </div>
                <div class ="mb-3">
                    
                    <input placeholder="Password" name="password" type="password" class="form-control"/>
                </div>
            </div>
      <div class="btn-group w-100">
        <a href="./register.php" class="btn btn-secondary text-white rounded-start w-50">Register</a>
        <button class="btn btn-primary w-50 text-white rounded-end" type="submit" value="Login">Login</button>
        </div>
    </form>
</body>

</html>