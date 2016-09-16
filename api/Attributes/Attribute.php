<?php
error_reporting(0);
session_start();

include_once 'AttributeHandler.php';
global $cMySQLi;
STX_DB();
$key = (isset($_REQUEST['key']) && !empty($_REQUEST['key'])) ? $_REQUEST['key'] : "";

switch(strtoupper($key)) {
    case 'SAVE':
        $attribute_name = (isset($_POST['attribute_name']) && !empty($_POST['attribute_name'])) ? $_POST['attribute_name'] : "";
        $attribute_values = (isset($_POST['attribute_value']) && !empty($_POST['attribute_value'])) ? $_POST['attribute_value'] : "";
        $id = saveAttribute($attribute_name, $attribute_values);
        break;

    case 'GET':
        $place_id = (isset($_GET['place_id']) && !empty($_GET['place_id'])) ? $_GET['place_id'] : "";
        $attributes = getAttributes($place_id);
        echo json_encode($attributes);
        break;
}
?>