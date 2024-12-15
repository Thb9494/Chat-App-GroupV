<?php
require "start.php";

if (!isset($_SESSION['user'])) {
    http_response_code(401); // not authorized
    header('Content-Type: application/json');
    echo json_encode(["message" => "No user in session stored"]);
    return;
}

$action=$_REQUEST["action"]??""; // Nutzen Sie Get oder Post
$friend=$_REQUEST["friend"]??""; // Nutzen Sie Get oder Post

if(empty($friend)) {
    http_response_code(400);
    header('Content-Type: application/json');
    echo json_encode(["message" => "Missing friend"]);
    return;
}

if(empty($friend)) {
    http_response_code(400);
    header('Content-Type: application/json');
    echo json_encode(["message" => "Missing action"]);
    return;
}

$result = false;
if($action === "add") {
    $result = $service->friendRequest(new Model\Friend($friend));
} else if($action === "remove") {
    $result = $service->removeFriend($friend);
} else if($action === "accept") {
    $result = $service->friendAccept($friend);
} else if($action === "dismiss") {
    $result = $service->friendDismiss($friend);
}

http_response_code($result ? 204 : 400);
if(!$result) {
    header('Content-Type: application/json');
    echo json_encode([
        "message" => "Could not finish friend action, see PHP error log for details"
    ]);
}
?>
