<?php
$list = array(1, 2, 3, 4, 5);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    foreach ($list as $value) {
        ?>
        <p><?= $value; ?></p>
    <?php }
    ?>
</body>

</html>