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

function registerUser($user_name, $user_email, $user_password, $user_cookie) {

    global $cMySQLi;
    STX_DB();

    $sQuery = "SELECT * FROM ".MYSQL_TBL_USERS." WHERE user_email = '$user_email' AND user_status = 1";

    if($aResult = $cMySQLi->query($sQuery)) {
        if ($aResult->num_rows > 0) {
            return false;
        }
    }
    $iQuery = "INSERT INTO ".MYSQL_TBL_USERS." (user_name, user_email, user_password, user_cookie) VALUES".chr(10);
    $iQuery .= "('$user_name', '$user_email', '".sha1($user_password)."', '$user_cookie')";

    if($cMySQLi->query($iQuery)) {
        return $cMySQLi->insert_id;
    } else {
        return false;
    }
}

function loginUser($user_email, $user_password) {

    global $cMySQLi;
    STX_DB();

    $sQuery = "SELECT * FROM ".MYSQL_TBL_USERS." WHERE user_email = '$user_email' AND user_password = '".sha1($user_password)."'";

    if($aResult = $cMySQLi->query($sQuery)) {
        if($aResult->num_rows > 0) {
            $aRow = $aResult->fetch_array(MYSQLI_ASSOC);
            return $aRow;
        } else {
            return false;
        }
    } else {
        return false;
    }
}