<?php

error_reporting(0);
include_once '../funcs.php';

function create_guest() {

    global $cMySQLi;
    STX_DB();

    $cookie_expiry = date('Y-m-d h:i:s', strtotime("+30 days"));
    $iQuery = "INSERT INTO ".MYSQL_TBL_GUEST." (user_cookie_expiry) VALUES".chr(10);
    $iQuery .= "('$cookie_expiry')";

    if($cMySQLi->query($iQuery)) {
        return $cMySQLi->insert_id;
    } else {
        return false;
    }
}