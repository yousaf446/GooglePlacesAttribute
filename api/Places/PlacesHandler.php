<?php

error_reporting(0);
include_once '../funcs.php';

function savePlace($place_id, $attribute_id, $attribute_value) {

    $cookie =  $_COOKIE["favourite_beverage"];
    $cookie_split = explode("_", $cookie);
    $user_id = $cookie_split[1];

    $attribute_split = explode("_", $attribute_id);
    $attribute_id = $attribute_split[1];
    global $cMySQLi;
    STX_DB();

    $sQuery = "SELECT * FROM ".MYSQL_TBL_PLACES." WHERE place_id = '$place_id' AND attribute_id = $attribute_id";

    $aPlace = false;
    if($aResult = $cMySQLi->query($sQuery)) {
        if($aResult->num_rows > 0) {
            while ($aRow = $aResult->fetch_array(MYSQLI_ASSOC)) {
                $aPlace = $aRow;
            }
        }
    }

    if($aPlace) {
        $prev_attr_value = $aPlace['attribute_value'];
        $prev_attr_date = $aPlace['update_date'];
        $iQuery = "INSERT INTO " . MYSQL_TBL_PLACES_HISTORY . " (place_id, user_id, attribute_id, attribute_value, dtm) VALUES" . chr(10);
        $iQuery .= "('$place_id', $user_id, $attribute_id, '$prev_attr_value', '$prev_attr_date')";

        $cMySQLi->query($iQuery);
    }

    if(!$aPlace) {
        $iQuery = "INSERT INTO ".MYSQL_TBL_PLACES." (place_id, user_id, attribute_id, attribute_value) VALUES".chr(10);
        $iQuery .= "('$place_id', $user_id, $attribute_id, '$attribute_value')";

        if($cMySQLi->query($iQuery)) {
            return $cMySQLi->insert_id;
        } else {
            return false;
        }
    } else {
        $uQuery = "UPDATE ".MYSQL_TBL_PLACES." SET attribute_value = '$attribute_value'".chr(10);
        $uQuery .= "WHERE place_id = '$place_id' AND attribute_id = $attribute_id";

        if($cMySQLi->query($uQuery)) {
            return true;
        } else {
            return false;
        }
    }
}

function getPlace($place_id, $filters = "") {

    global $cMySQLi;
    STX_DB();

    $sQuery = "SELECT * FROM ".MYSQL_TBL_PLACES." WHERE place_id = '$place_id'";

    $aPlace = false;
    if($aResult = $cMySQLi->query($sQuery)) {
        if($aResult->num_rows > 0) {
            $aPlace = true;
        }
    }

    if($aPlace) {
        $filterQuery = "AND (";
        $filterCount = 0;
        foreach($filters as $key => $value) {
            if($filterCount > 1) {
                $filterQuery .= " OR";
            }
            if(!empty($value)) {
                $filterQuery .= " (attribute_id = $key AND attribute_value = '$value')";
            }
            $filterCount++;
        }

        $filterQuery .= ")";
        $sQuery = "SELECT * FROM ".MYSQL_TBL_PLACES." WHERE place_id = '$place_id'".chr(10);
        if(!empty($filters)) $sQuery .= $filterQuery;

        if($aResult = $cMySQLi->query($sQuery)) {
            if($aResult->num_rows > 0) {
                while ($aRow = $aResult->fetch_array(MYSQLI_ASSOC)) {
                    if($aRow['attribute_id'] == 1)
                        $aPlace = $aRow;
                }
            }
        }

        $aPlace = $aPlace['attribute_value'];
    }
    return $aPlace;
}