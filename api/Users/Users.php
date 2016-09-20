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
            $cookie_value = [];
            $cookie_value['guest'] = "guest_" . $id;
            $cookie_value['user'] = "";
            setcookie($cookie_name, json_encode($cookie_value), time() + (86400 * 30), "/");
            echo json_encode($cookie_value);
        }
        break;
    case 'REGISTER':
        $user_name = (isset($_POST['user_name']) && !empty($_POST['user_name'])) ? $_POST['user_name'] : "";
        $user_email = (isset($_POST['user_email']) && !empty($_POST['user_email'])) ? $_POST['user_email'] : "";
        $user_password = (isset($_POST['user_password']) && !empty($_POST['user_password'])) ? $_POST['user_password'] : "";
        $user_cookie = (isset($_COOKIE["favourite_beverage"]) && !empty($_COOKIE["favourite_beverage"])) ? json_decode($_COOKIE["favourite_beverage"]) : "";

        if($user_cookie == "") {
            $guest_id = create_guest();
        }
        $cookie_guest  = (!empty($user_cookie) ? $user_cookie->guest : 'guest_'.$guest_id);
        $id = registerUser($user_name, $user_email, $user_password, $cookie_guest);

        if($id) {
            $cookie_name = "favourite_beverage";
            $cookie_value = [];
            $cookie_value['guest'] = $cookie_guest;
            $cookie_value['user'] = $user_name;
            setcookie($cookie_name, json_encode($cookie_value), time() + (86400 * 30), "/");
            header("Location: ../../index.php");
        } else {
            header("Location: ../../register.php?error=2");
        }
        break;
    case 'LOGIN':
        $user_email = (isset($_POST['user_email']) && !empty($_POST['user_email'])) ? $_POST['user_email'] : "";
        $user_password = (isset($_POST['user_password']) && !empty($_POST['user_password'])) ? $_POST['user_password'] : "";

        $data = loginUser($user_email, $user_password);

        if($data) {
            $cookie_name = "favourite_beverage";
            $cookie_value = [];
            $cookie_value['guest'] = $data['user_cookie'];
            $cookie_value['user'] = $data['user_name'];
            setcookie($cookie_name, json_encode($cookie_value), time() + (86400 * 30), "/");
            header("Location: ../../index.php");
        } else {
            header("Location: ../../register.php?error=1");
        }
        break;
}
?>