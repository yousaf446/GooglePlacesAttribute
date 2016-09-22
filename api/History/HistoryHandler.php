<?php

error_reporting(0);
include_once '../funcs.php';

function getHistory() {

    $cookie =  json_decode($_COOKIE["favourite_beverage"]);
    $cookie = $cookie->guest;
    $cookie_split = explode("_", $cookie);
    $user_id = $cookie_split[1];

    global $cMySQLi;
    STX_DB();

    $sQuery = "SELECT his.*, attr.attribute_name FROM ".MYSQL_TBL_PLACES_HISTORY." his LEFT OUTER JOIN ".MYSQL_TBL_ATTRIBUTE." attr ON
    his.attribute_id = attr.attribute_id WHERE user_id = $user_id";

    $aHistory = [];
    if($aResult = $cMySQLi->query($sQuery)) {
        if($aResult->num_rows > 0) {
            while ($aRow = $aResult->fetch_array(MYSQLI_ASSOC)) {
                $aHistory[] = $aRow;
            }
        }
    }
    return $aHistory;
}
