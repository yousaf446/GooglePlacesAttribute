<?php
error_reporting(0);
session_start();

include_once 'HistoryHandler.php';
global $cMySQLi;
STX_DB();
$key = (isset($_REQUEST['key']) && !empty($_REQUEST['key'])) ? $_REQUEST['key'] : "";

switch(strtoupper($key)) {

    case 'GET':
        $cookie = $_COOKIE["favourite_beverage"];
        $history = getHistory();
        echo json_encode($history);
        break;
}
?>