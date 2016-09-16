<?php
error_reporting(0);
session_start();

include_once 'PlacesHandler.php';
global $cMySQLi;
STX_DB();
$key = (isset($_REQUEST['key']) && !empty($_REQUEST['key'])) ? $_REQUEST['key'] : "";

switch(strtoupper($key)) {
    case 'SAVE':
        $place_id = (isset($_POST['place_id']) && !empty($_POST['place_id'])) ? $_POST['place_id'] : "";
        $attribute_id = (isset($_POST['attribute_id']) && !empty($_POST['attribute_id'])) ? $_POST['attribute_id'] : "";
        $attribute_value = (isset($_POST['attribute_value']) && !empty($_POST['attribute_value'])) ? $_POST['attribute_value'] : "";
        savePlace($place_id, $attribute_id, $attribute_value);
        break;

    case 'GET':
        $place_id = (isset($_GET['place_id']) && !empty($_GET['place_id'])) ? $_GET['place_id'] : "";
        $filters = (isset($_GET['filters']) && !empty($_GET['filters'])) ? json_decode($_GET['filters']) : "";
        $place = getPlace($place_id, $filters);
        echo $place;
        break;
}
?>