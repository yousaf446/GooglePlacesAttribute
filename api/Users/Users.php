<?php
error_reporting(0);
session_start();

include_once 'UsersHandler.php';
global $cMySQLi;
STX_DB();
$key = (isset($_REQUEST['key']) && !empty($_REQUEST['key'])) ? $_REQUEST['key'] : "";

switch(strtoupper($key)) {
    case 'SETCOOKIE':
        if( isset($_COOKIE["favourite_beverage"])) {
            echo $_COOKIE["favourite_beverage"];
        } else {
            $id = create_guest();
            $cookie_name = "favourite_beverage";
            $cookie_value = "guest_" . $id;
            setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
            echo $cookie_value;
        }
        break;
}
?>