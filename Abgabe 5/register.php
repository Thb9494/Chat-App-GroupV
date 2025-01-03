<?php

require("start.php");

// Initialisiere Variablen
$username = $password = $confirmPassword = "";
$usernameError = $passwordError = $confirmPasswordError = "";

// Instanz des BackendService erstellen
//$service = new Utils\BackendService("https://online-lectures-cs.thi.de/chat/", "c49d4fa0-6113-4b89-ac33-ebda6d4a5e96");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirmPassword = trim($_POST['confirmPassword'] ?? '');

    // Nutzernamen prüfen
    if (empty($username) || strlen($username) < 3) {
        $usernameError = "Der Nutzername muss mindestens 3 Zeichen lang sein.";
    } elseif ($service->userExists($username)) {
        $usernameError = "Der Nutzername ist bereits vergeben.";
    }

    // Passwort prüfen
    if (empty($password)) {
        $passwordError = "Das Passwort darf nicht leer sein.";
    } elseif (strlen($password) < 8) {
        $passwordError = "Das Passwort muss mindestens 8 Zeichen lang sein.";
    }

    // Passwort-Wiederholung prüfen
    if ($password !== $confirmPassword) {
        $confirmPasswordError = "Die Passwörter stimmen nicht überein.";
    }

    // Registrierung durchführen
    if (empty($usernameError) && empty($passwordError) && empty($confirmPasswordError)) {
        // Benutzer registrieren
        $result = $service->register($username, $password);
        
        if ($result) {
            // Speichern der Benutzerdaten
            $user = $service->loadUser($username);
            if ($user) {
                $saveResult = $service->saveUser($user);
                if ($saveResult) {
                    // Erfolgreiche Speicherung der Benutzerdaten
                    $_SESSION['user'] = $username;
                    header("Location: friends.php");
                    exit();
                } else {
                    // Fehler beim Speichern der Benutzerdaten
                    $usernameError = "Fehler beim Speichern des Benutzers. Bitte versuchen Sie es erneut.";
                }
            } else {
                // Fehler beim Laden der Benutzerdaten
                $usernameError = "Fehler beim Laden der Benutzerdaten. Bitte versuchen Sie es erneut.";
            }
        } else {
            // Fehler bei der Registrierung
            $usernameError = "Registrierung fehlgeschlagen. Bitte versuchen Sie es erneut.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="./style.css" />
    <script src="./registerJS.js" defer></script>
</head>
<body class="bg-light">
<img class="roundimg" src="../images/user.png" width="100" height="100" />

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="text-center">
                        <h2>Register yourself</h2>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="" class="row g-3 needs-validation" novalidate>
                            <div class="mb-3">
                                <input 
                                    type="text" 
                                    class="form-control <?php echo !empty($usernameError) ? 'is-invalid' : (empty($username) ? '' : 'is-valid'); ?>" 
                                    id="username" 
                                    name="username" 
                                    placeholder="Username"
                                    value="<?php echo htmlspecialchars($username); ?>" 
                                    required>
                            </div>
                            <div class="mb-3">
                                <input 
                                    type="password" 
                                    class="form-control <?php echo !empty($passwordError) ? 'is-invalid' : (empty($password) ? '' : 'is-valid'); ?>" 
                                    id="password" 
                                    name="password" 
                                    placeholder="Password"
                                    required>
                            </div>
                            <div class="mb-3">
                                <input 
                                    type="password" 
                                    class="form-control <?php echo !empty($confirmPasswordError) ? 'is-invalid' : (empty($confirmPassword) ? '' : 'is-valid'); ?>" 
                                    id="confirmPassword" 
                                    name="confirmPassword"
                                    placeholder="Confirm Password"
                                    required>
                            </div>
                            <div class="btn-group">
                                <a href="./login.php" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">Create Account</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
