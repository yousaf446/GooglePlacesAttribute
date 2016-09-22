<?php

$cookie = json_decode($_COOKIE["favourite_beverage"]);
if(empty($cookie->user)) {
    "You are not allowed to view history";exit();
}