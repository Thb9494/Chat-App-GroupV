<?php
require "start.php";

if (!isset($_SESSION['user'])) {
    http_response_code(401); // not authorized
    header('Content-Type: application/json');
    echo json_encode(["message" => "No user in session stored"]);
    return;
}

if (!isset($_GET['to'])) {
    http_response_code(400); // bad request
    header('Content-Type: application/json');
    echo json_encode(["message" => "Missing to in query"]);
    return;
}

$to = $_GET['to'];
// Nachrichten zwischen aktuellem Benutzer und "$to" laden
$messages = $service->loadMessages($to);

if (!$messages) {
    // Fehler aufgetreten: leeres Array senden, damit der Client immer
    // ein Array zum Anzeigen hat
    $messages = array();
}
// Nachrichten im JSON-Format senden
echo json_encode($messages);
http_response_code(200);
?>
