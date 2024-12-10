<?php require("start.php");
$service = new Utils\BackendService("https://online-lectures-cs.thi.de/chat/", "188f343e-a48e-43f9-a5c5-44982a6c7b7a");
var_dump($service->test());
var_dump($service->login("Test123", "12345678"));
var_dump($service->loadUser("Test123"));