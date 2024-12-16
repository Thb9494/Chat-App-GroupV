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
    $message = "Wähle einen Freund aus, um zu chatten.";
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
    <link rel="stylesheet" href="style.css">
    <script src="chat.js" defer></script>
    <script>
        const currentUser = "<?php echo htmlspecialchars($user); ?>";
    </script>
</head>
<body>
    <h1 class="h1left"><?php echo $message; ?></h1>

    <?php if (empty($chatPartner)): ?>
        <div>
            <h2>Freunde</h2>
        </div>
        <?php else: ?>
        <div class="navbar">
        <a href="friends.php" class="leftL">&lt; Back</a> |
        <a href="profile.php" class="leftL">Profil</a> |
        <a href="chat.php?action=remove_friend&friend=<?php echo urlencode($chatPartner); ?>" class="remove-friend">Remove Friends</a>
        </div>
        <hr>

        <div class="chatfield">
            <div class="chattext" id="sent-messages-container"></div>
            <div class="chattext" id="message-container"></div>
        </div>

        <hr>
        <div class="chat">
            <form id="message-form" method="POST" >
                <input type="text" class="chatinput" id="message-input" placeholder="New Message" required>
                <button type="submit" class="send-add-button" id="send-button">Send</button>
            </form>
        </div>
    <?php endif; ?>
</body>
</html>

