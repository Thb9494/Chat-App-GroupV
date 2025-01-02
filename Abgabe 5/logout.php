<?php
require("start.php");
session_unset(); //oder lieber session_destroy()?
?>
<!DOCTYPE html>
<html>

<head>
    <title>Logged Out</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</head>

<body class="d-flex justify-content-center align-items-start bg-light" style="height: 100vh">
    <div class="text-center mt-5">
        
        <img class="rounded-circle mb-4" src="../images/logout.png" width="100" height="100">

        <div class="container-fluid border p-4 rounded bg-white">
            
            <h4>Logged out...</h4>
            <p>See u!</p>

            
            <a href="login.php" class="btn btn-secondary w-100 text-white rounded">Login again</a>
        </div>
    </div>
</body>
</html>