<?php

require("start.php");

// Prüfen, ob der Nutzer angemeldet ist
if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
$service = new Utils\BackendService("https://online-lectures-cs.thi.de/chat/", "c49d4fa0-6113-4b89-ac33-ebda6d4a5e96");

$user = $_SESSION['user']; // Angemeldeten Nutzer aus der Session holen
$chatPartner = htmlspecialchars($_GET['friend'] ?? ''); // Freund aus der URL holen

// Prüfen, ob ein Freund entfernt werden soll
if (isset($_GET['action']) && $_GET['action'] === 'remove_friend') {
    $friendToRemove = htmlspecialchars($_GET['friend'] ?? '');

    if (!empty($friendToRemove)) {
        try {
            if ($service->removeFriend($friendToRemove)) {
                header("Location: friends.php?message=Freund wurde erfolgreich entfernt");
                exit();
            } else {
                header("Location: chat.php?friend=" . urlencode($friendToRemove) . "&error=Fehler beim Entfernen des Freundes");
                exit();
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            header("Location: chat.php?friend=" . urlencode($friendToRemove) . "&error=Ein Fehler ist aufgetreten");
            exit();
        }
    } else {
        header("Location: chat.php?error=Kein Freund angegeben");
        exit();
    }
}

if (empty($chatPartner)) {
    header("Location: friends.php");
} else {
    $message = "Chat with $chatPartner";
}


// Prüfen, ob eine Nachricht gesendet werden soll
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $message = new stdClass();
    $message->msg = $_POST["msg"] ?? null;
    $message->to = $_POST["to"] ?? null;

    if ($message->msg && $message->to) {
        $success = $service->sendMessage($message);

        if ($success) {
            http_response_code(200);
            echo json_encode(["status" => "success"]);
        } else {
            http_response_code(500);
            echo json_encode(["status" => "error", "message" => "Fehler beim Senden der Nachricht"]);
        }
    } else {
        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "Ungültige Nachricht"]);
    }
    exit();
}

?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <script src="chat.js" defer></script>
    <script>
        const currentUser = "<?php echo htmlspecialchars($user); ?>";
    </script>
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-start"><?php echo $message; ?></h1>

        <?php if (empty($chatPartner)): ?>
            <div>
                <h2>Freunde</h2>
            </div>
        <?php else: ?>

            <!-- Button Gruppe -->
            <div class="d-flex justify-content-start mt-2">
                <div class="navbar btn-group">
                    <a href="friends.php" class="btn btn-secondary">&lt; Back</a>
                    <a href="profile.php" class="btn btn-secondary">Show Profil</a>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#removeFriendModal">Remove Friend</button>
                </div>
            </div>

            <!-- Chat Nachrichten -->
            <div class="chatfield bg-light p-3 rounded mt-3">
                <div class="chattext" id="sent-messages-container"></div>
                <div class="chattext" id="message-container"></div>
            </div>


            <!-- Neue Nachricht -->
            <form id="message-form" method="POST" class="input-group mt-3">
                <input type="text" class="form-control" id="message-input" placeholder="New Message" required>
                <button type="submit" class="btn btn-primary" id="send-button">Send</button>
            </form>

            <!-- Freund entfernen Modal -->
            <div class="modal fade" id="removeFriendModal" tabindex="-1" aria-labelledby="removeFriendModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title" id="removeFriendModalLabel"> Remove <?php echo htmlspecialchars($chatPartner); ?> as Friend</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body text-start">
                            Do you really want to end your friendship?
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <a href="chat.php?action=remove_friend&friend=<?php echo urlencode($chatPartner); ?>" class="btn btn-primary">Yes, Please!</a>
                        </div>

                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>


