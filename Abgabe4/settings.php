<?php
require("start.php");

if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$currentUser = $service->loadUser($_SESSION['user']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = new Model\User($_SESSION['user']);
    $user->setFirstName(htmlspecialchars($_POST['firstName'] ?? ''));
    $user->setLastName(htmlspecialchars($_POST['lastName'] ?? ''));
    $user->setCoffeeOrTea(htmlspecialchars($_POST['beverages'] ?? ''));
    $user->setDescription(htmlspecialchars($_POST['description'] ?? ''));
    $user->setChatLayout(htmlspecialchars($_POST['chatLayout'] ?? ''));
    $user->addToHistory(); 

    if ($service->saveUser($user)) {
        header("Location: friends.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Settings</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1 class="h1left">Profile Settings</h1>
    <form action="setting.php" method="post">
        <fieldset>
            <legend>Base Data</legend>
            <div class="field">
                <label for="firstName" class="input-descriptor">First Name</label>
                <input type="text" id="firstName" name="firstName" placeholder="Your Name" 
                    value="<?= htmlspecialchars($currentUser->getFirstName() ?? '') ?>">
            </div>
            <div class="field">
                <label for="lastName" class="input-descriptor">Last Name</label>
                <input type="text" id="lastName" name="lastName" placeholder="Your Surname"
                    value="<?= htmlspecialchars($currentUser->getLastName() ?? '') ?>">
            </div>
            <div class="field">
                <label for="beverages" class="input-descriptor">Coffee or Tea?</label>
                <select id="beverages" name="beverages">
                    <?php
                    $options = ['Neither nor', 'Coffee', 'Tea', 'Both'];
                    $currentChoice = $currentUser->getCoffeeOrTea();
                    foreach ($options as $option) {
                        $selected = ($currentChoice === $option) ? 'selected' : '';
                        echo "<option value=\"$option\" $selected>$option</option>";
                    }
                    ?>
                </select>
            </div>
        </fieldset>

        <fieldset>
            <legend>Tell Something About You</legend>
            <textarea name="description" rows="6" cols="110"><?= htmlspecialchars($currentUser->getDescription() ?? '') ?></textarea>
        </fieldset>

        <fieldset>
            <legend>Preferred Chat Layout</legend>
            <?php
            $currentLayout = $currentUser->getChatLayout();
            ?>
            <input type="radio" id="oneLine" name="chatLayout" value="oneLine"
                <?= ($currentLayout === 'oneLine') ? 'checked' : '' ?>>
            <label for="oneLine" class="input-descriptor">Username and message in one line</label><br>
            <input type="radio" id="twoLines" name="chatLayout" value="twoLines"
                <?= ($currentLayout === 'twoLines') ? 'checked' : '' ?>>
            <label for="twoLines" class="input-descriptor">Username and message in separate lines</label><br>
        </fieldset>

        <button type="button" class="regular-button" onclick="window.location.href='freundeliste.php'">Cancel</button>
        <input type="submit" class="primary-action-button" value="Save">
    </form>
</body>
</html>