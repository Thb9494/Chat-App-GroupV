<?php
require("start.php");


if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$profileUsername = $_GET['friend'] ?? $_SESSION['user']; 

try {
    $profileUser = $service->loadUser($profileUsername);
    if (!$profileUser) {
        throw new Exception("User not found");
    }

    $isFriend = false;
    if ($profileUsername !== $_SESSION['user']) {
        $friends = $service->loadFriends();
        foreach ($friends as $friend) {
            if ($friend->username === $profileUsername && $friend->status === "accepted") {
                $isFriend = true;
                break;
            }
        }
    }
} catch (Exception $e) {
    error_log($e->getMessage());
    header("Location: friends.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1 class="h1left">Profile of <?= htmlspecialchars($profileUsername) ?></h1>
    <a href="friends.php" class="leftL"> &lt; Back to Chat</a>
    <?php if ($isFriend): ?>
        |
        <a href="freundeliste.php?action=remove&friend=<?= urlencode($profileUsername) ?>" 
           class="leftL remove-friend">Remove Friend</a>
    <?php endif; ?>
    <hr>
    
    <div class="profile-container">
        <img src="images/user.png" id="profilPicture" alt="Profile Picture" class="profileimg roundimg">
        <fieldset>
            <p><?= nl2br(htmlspecialchars($profileUser->description ?? '')) ?></p>
            <p><strong>Coffee or Tea?</strong></p>
            <p class="profileanswers"><?= htmlspecialchars($profileUser->coffeeOrTea ?? 'Not specified') ?></p>
            <p><strong>Name</strong></p>
            <p class="profileanswers">
                <?= htmlspecialchars(trim(($profileUser->firstName ?? '') . ' ' . 
                    ($profileUser->lastName ?? ''))) ?>
            </p>
            
            <?php if ($profileUsername === $_SESSION['user']): ?>
                <h3 class="h2left">Profile Change History</h3>
                <ul>
                    <?php 
                    $history = $profileUser->changeHistory ?? [];
                    foreach ($history as $change): 
                    ?>
                        <li><?= htmlspecialchars($change) ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </fieldset>
    </div>
</body>
</html>