<?php
$testWert = "";
if (isset($_POST['test'])) { $testWert = $_POST['test'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form method="post" action="test.php">
        <input name="test" value="<?= $testWert; ?>">
        <button type="submit" name="action" value="foo1">Absenden 1</button>
        <button type="submit" name="action" value="foo2">Absenden 2</button>
        <button type="submit" name="bar" value="foo3">Absenden 3</button>
    </form>
    <?php var_dump($_POST); ?>
</body>

</html>