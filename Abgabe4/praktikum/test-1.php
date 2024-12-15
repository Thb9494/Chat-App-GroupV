<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    if(isset($_GET["test"])) {
        if(!empty($_GET["test"])) {
            echo "Wert: ".$_GET["test"];
        } else {
            echo "Kein Wert!";
        }
    } else {
        echo "Kein Parameter übergeben";
    }

    ?>

</body>

</html>