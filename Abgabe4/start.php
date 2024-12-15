<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


spl_autoload_register(function($class) {
    include str_replace('\\', '/', $class) . '.php';
});

session_start();

//Kannn weggelassen werden
define('CHAT_SERVER_URL', 'https://online-lectures-cs.thi.de/chat/');
define('CHAT_SERVER_ID', 'c49d4fa0-6113-4b89-ac33-ebda6d4a5e96'); 

$service = new Utils\BackendService(CHAT_SERVER_URL, CHAT_SERVER_ID);
?>