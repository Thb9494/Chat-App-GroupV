<?php

// Prüfen, ob der Nutzer angemeldet ist
if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    //Nutzer ist nicht eingeloggt, Weiterleitung zur Login-Seite
    //header("Location: login.php");
    //exit(); // Skript hier beenden
}

require("start.php"); 
$user = $_SESSION['user']; // Angemeldeten Nutzer aus der Session holen


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
        <a href="remove_friend.php?friend=<?php echo urlencode($chatPartner); ?>" class="leftL critical">Freund
            entfernen</a>
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