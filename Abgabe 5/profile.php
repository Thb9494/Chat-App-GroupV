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
            if ($friend->getUsername() === $profileUsername && $friend->getStatus() === "accepted") {
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-light">
    <div class="container py-4">
        <h1 class="mb-4">Profile of <?= htmlspecialchars($profileUsername) ?></h1>
        
        <div class="d-flex gap-2 mb-4">
            <a href="friends.php" class="btn btn-secondary">&lt; Back to Friends</a>
            <?php if ($isFriend): ?>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#removeFriendModal">
                    Remove Friend
                </button>
            <?php endif; ?>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="text-center mb-4">
                    <img src="images/user.png" alt="Profile Picture" class="rounded-circle" style="width: 200px; height: 200px;">
                </div>

                <div class="mb-4">
                    <h4>About</h4>
                    <p class="lead"><?= nl2br(htmlspecialchars($profileUser->getDescription() ?? 'No description available')) ?></p>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <h4>Coffee or Tea?</h4>
                        <p class="lead"><?= htmlspecialchars($profileUser->getCoffeeOrTea() ?? 'Not specified') ?></p>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <h4>Name</h4>
                        <p class="lead">
                            <?php 
                            $fullName = trim(($profileUser->getFirstName() ?? '') . ' ' . ($profileUser->getLastName() ?? ''));
                            echo htmlspecialchars($fullName ?: 'Not specified');
                            ?>
                        </p>
                    </div>
                </div>

                <?php if ($profileUsername === $_SESSION['user']): ?>
                    <div class="mt-4">
                        <h4>Profile Change History</h4>
                        <div class="list-group">
                            <?php foreach ($profileUser->getChangeHistory() ?? [] as $change): ?>
                                <div class="list-group-item">
                                    <?= htmlspecialchars($change) ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php if ($isFriend): ?>
    <!-- Remove Friend Modal -->
    <div class="modal fade" id="removeFriendModal" tabindex="-1" aria-labelledby="removeFriendModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="removeFriendModalLabel">Remove Friend</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to remove <?= htmlspecialchars($profileUsername) ?> from your friends list?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a href="friends.php?action=remove&friend=<?= urlencode($profileUsername) ?>" 
                       class="btn btn-danger">Yes, Remove Friend</a>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</body>
</html>