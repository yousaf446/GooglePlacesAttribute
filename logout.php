<?php

$curr_cookie = json_decode($_COOKIE["favourite_beverage"]);
$cookie_name = "favourite_beverage";
$cookie_value = [];
$cookie_value['guest'] = $curr_cookie->guest;
$cookie_value['user'] = "";
setcookie($cookie_name, json_encode($cookie_value), time() + (86400 * 30), "/");
header("Location: index.php");