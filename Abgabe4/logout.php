<?php
    require("start.php");
    session_unset();
?>
<!DOCTYPE html>
<html>
    <head>
       <title>Logged Out</title>
       <link rel="stylesheet" href="./style.css">
    </head>

    <body>
        <img class="roundimg" src="../images/logout.png"
        width="100"
        height="100">
        
        <h1>
            Logged out...
        </h1>

        <p>
            See u!
        </p>

        <a 
            href="login.php"> Login again </a>


    </body>
</html>