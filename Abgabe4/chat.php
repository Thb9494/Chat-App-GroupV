<?php

// Prüfen, ob der Nutzer angemeldet ist
if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    //Nutzer ist nicht eingeloggt, Weiterleitung zur Login-Seite
    //header("Location: login.php");
    //exit(); // Skript hier beenden
}

require("start.php"); 
$user = $_SESSION['user']; // Angemeldeten Nutzer aus der Session holen
$service = new Utils\BackendService(CHAT_SERVER_URL, CHAT_SERVER_ID);


// Prüfen, ob ein Freund entfernt werden soll
if (isset($_GET['action']) && $_GET['action'] === 'remove_friend') {
    $friendToRemove = htmlspecialchars($_GET['friend'] ?? '');

    if (!empty($friendToRemove)) {
        // BackendService: removeFriend aufrufen
        try {
            if ($service->removeFriend($friendToRemove)) {
                // Erfolg: Weiterleitung zur Freundesliste
                header("Location: friends.php?message=Freund wurde erfolgreich entfernt");
                exit();
            } else {
                // Fehler beim Entfernen
                header("Location: chat.php?friend=" . urlencode($friendToRemove) . "&error=Fehler beim Entfernen des Freundes");
                exit();
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            header("Location: chat.php?friend=" . urlencode($friendToRemove) . "&error=Ein Fehler ist aufgetreten");
            exit();
        }
    } else {
        // Kein Freund angegeben
        header("Location: chat.php?error=Kein Freund angegeben");
        exit();
    }
}


$chatPartner = htmlspecialchars($_GET['friend'] ?? ''); // Freund aus der URL holen

// Wenn kein Freund angegeben ist, kann eine Nachricht oder die Freundesliste angezeigt werden
if (empty($chatPartner)) {
    $message = "Wähle einen Freund aus, um zu chatten.";

} else {
    $message = "Chat mit $chatPartner";
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
        // Übergeben Sie den Namen des aktuell eingeloggten Nutzers an das JavaScript
        const currentUser = "<?php echo htmlspecialchars($user); ?>";
    </script>
</head>

<body>
    <h1 class="left"><?php echo $message; ?></h1>
    <?php if (empty($chatPartner)): ?>
        <div>
            <h2>Freunde</h2>
            <ul>
                <?php
                // Hier würden Freunde des Benutzers angezeigt werden
                ?>
            </ul>
        </div>
    <?php else: ?>
        <a href="friends.php" class="leftL">&lt; Zurück zur Freundesliste</a> |
        <a href="profile.php" class="leftL">Profil</a> |
        <a href="chat.php?action=remove_friend&friend=<?php echo urlencode($chatPartner); ?>" class="leftL critical">Freund entfernen</a>
        <hr>

        <div>


            <div class="chatfield">
                <!-- Hier werden die gesendeten Nachrichten angezeigt -->
                <div id="sent-messages-container">
                    <!-- Die gesendeten Nachrichten werden hier angezeigt -->
                </div>

                <!-- Container für geladene Nachrichten -->
                <div id="message-container">
                    <!-- Die geladenen Nachrichten werden hier angezeigt -->
                </div>
            </div>

            <hr>
            <!-- Formular zum Senden von Nachrichten -->
            <div class="chat">
                <form id="chat-form">
                    <input type="text" class="chatinput" id="message-input" placeholder="Nachricht eingeben..." required>
                    <button type="submit" class="send-add-button" id="send-button">Senden</button>
                </form>
            </div>
        </div>
    <?php endif; ?>
</body>

</html>