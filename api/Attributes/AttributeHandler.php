<?php

error_reporting(0);
include_once '../funcs.php';

function saveAttribute($attribute_name, $attribute_type, $attribute_values) {

    global $cMySQLi;
    STX_DB();

    $iQuery = "INSERT INTO ".MYSQL_TBL_ATTRIBUTE." (attribute_name, attribute_type, attribute_value) VALUES".chr(10);
    $iQuery .= "('$attribute_name', '$attribute_type', '$attribute_values')";

    if($cMySQLi->query($iQuery)) {
        return $cMySQLi->insert_id;
    } else {
        return false;
    }
}

function getAttributes($place_id = "") {

    global $cMySQLi;
    STX_DB();

    $aData = array();
    $sQuery = "SELECT * FROM ".MYSQL_TBL_ATTRIBUTE.chr(10);
    $sQuery .= "WHERE attribute_status = 1";

    if($aResult = $cMySQLi->query($sQuery)) {
        while($aRow = $aResult->fetch_array(MYSQLI_ASSOC)) {
            $aData['attributes'][] = $aRow;
        }
    }

    if(!empty($place_id)) {
        $sQuery = "SELECT * FROM " . MYSQL_TBL_PLACES . chr(10);
        if (!empty($place_id)) {
            $sQuery .= "WHERE place_id = '$place_id'";
        }

        if ($aResult = $cMySQLi->query($sQuery)) {
            while ($aRow = $aResult->fetch_array(MYSQLI_ASSOC)) {
                $aData['place'][] = $aRow;
            }
        }
    }
    return $aData;
}

function getAllAttributes() {

    global $cMySQLi;
    STX_DB();

    $aData = array();
    $sQuery = "SELECT * FROM ".MYSQL_TBL_ATTRIBUTE.chr(10);
    $sQuery .= "WHERE attribute_status = 1";

    if($aResult = $cMySQLi->query($sQuery)) {
        while($aRow = $aResult->fetch_array(MYSQLI_ASSOC)) {
            $aData[] = $aRow;
        }
    }
    return $aData;
}