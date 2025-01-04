<?php
require("start.php");

if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$currentUser = $service->loadUser($_SESSION['user']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = new Model\User($_SESSION['user']);
    $user->setFirstName($_POST['firstName'] ?? '');
    $user->setLastName($_POST['lastName'] ?? '');
    $user->setCoffeeOrTea($_POST['beverages'] ?? '');
    $user->setDescription($_POST['description'] ?? '');
    $user->setChatLayout($_POST['chatLayout'] ?? '');
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-light">
    <div class="container py-4">
        <h1 class="mb-4">Profile Settings</h1>
        
        <div class="card">
            <div class="card-body">
                <form action="" method="post" class="needs-validation" novalidate>
                    <div class="mb-4">
                        <h5 class="card-title">Base Data</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="firstName" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="firstName" name="firstName" 
                                       value="<?= htmlspecialchars($currentUser->getFirstName() ?? '') ?>">
                            </div>
                            
                            <div class="col-md-6">
                                <label for="lastName" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="lastName" name="lastName" 
                                       value="<?= htmlspecialchars($currentUser->getLastName() ?? '') ?>">
                            </div>
                            
                            <div class="col-md-6">
                                <label for="beverages" class="form-label">Coffee or Tea?</label>
                                <select class="form-select" id="beverages" name="beverages">
                                    <?php
                                    $options = ['Neither nor', 'Coffee', 'Tea', 'Both'];
                                    $currentChoice = $currentUser->getCoffeeOrTea();
                                    foreach ($options as $option) {
                                        $selected = ($currentChoice === $option) ? 'selected' : '';
                                        echo "<option value=\"" . htmlspecialchars($option) . "\" $selected>" . 
                                             htmlspecialchars($option) . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h5 class="card-title">About You</h5>
                        <div class="mb-3">
                            <label for="description" class="form-label">Tell us about yourself</label>
                            <textarea class="form-control" id="description" name="description" 
                                      rows="4"><?= htmlspecialchars($currentUser->getDescription() ?? '') ?></textarea>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h5 class="card-title">Chat Preferences</h5>
                        <div class="mb-3">
                            <?php $currentLayout = $currentUser->getChatLayout(); ?>
                            <div class="form-check mb-2">
                                <input type="radio" class="form-check-input" id="oneLine" name="chatLayout" 
                                       value="oneLine" <?= ($currentLayout === 'oneLine') ? 'checked' : '' ?>>
                                <label class="form-check-label" for="oneLine">
                                    Username and message in one line
                                </label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="twoLines" name="chatLayout" 
                                       value="twoLines" <?= ($currentLayout === 'twoLines') ? 'checked' : '' ?>>
                                <label class="form-check-label" for="twoLines">
                                    Username and message in separate lines
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="friends.php" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>