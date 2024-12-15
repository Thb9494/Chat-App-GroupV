<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


spl_autoload_register(function($class) {
    include str_replace('\\', '/', $class) . '.php';
});

session_start();

CHAT_SERVER_URL = "https://online-lectures-cs.thi.de/chat/";
CHAT_SERVER_ID = "581086a3-ef94-49a8-b4bf-6acca0d0c9a5";

$service = new Utils\BackendService(CHAT_SERVER_URL, CHAT_SERVER_ID);
?