<?php
require "start.php";

if (!isset($_SESSION['user'])) {
    http_response_code(401); // not authorized
    header('Content-Type: application/json');
    echo json_encode(["message" => "No user in session stored"]);
    return;
}

// Backend aufrufen
$users = $service->loadUsers();
if ($users) {
    // erhaltene Friend-Objekte im JSON-Format senden 
    echo json_encode($users);
}
/* http status code setzen
 * - 200 users gesendet
 * - 404 Fehler
 */
http_response_code($users ? 200 : 404);
?>
