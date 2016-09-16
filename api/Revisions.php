<?php
error_reporting(0);
session_start();
include_once 'funcs.php';
global $cMySQLi;
STX_DB();
$key = (isset($_REQUEST['key']) && !empty($_REQUEST['key'])) ? $_REQUEST['key'] : "";

switch(strtoupper($key)) {
    case 'LOGIN':
        $sUsername = (isset($_POST['username']) && !empty($_POST['username'])) ? $_POST['username'] : "";
        $sPassword = (isset($_POST['password']) && !empty($_POST['password'])) ? $_POST['password'] : "";
        /*$sQuery = "SELECT * FROM ".MYSQL_TBL_DRIVER." WHERE driver_username = '$sUsername' AND driver_password = '$sPassword'";
        if($aResult = $cMySQLi->query($sQuery)) {
            if($aResult->num_rows > 0) {
                $aRow = $aResult->fetch_array();
                $_SESSION['driver'] = array();
                $_SESSION['driver']['name'] = $aRow['driver_name'];
                $_SESSION['driver']['id'] = $aRow['driver_id'];
                echo json_encode($_SESSION['driver']);
            }  else {
                echo 'fail';
            }
        }*/
        $_SESSION['driver'] = array();
        $_SESSION['driver']['status'] = false;
        if(strlen($sUsername) == 5 && $sPassword == '123456') {
            $_SESSION['driver']['name'] = $sUsername;
            $_SESSION['driver']['status'] = true;
        }
        echo json_encode($_SESSION['driver']);
        break;

    case 'LOGOUT':
        $driverID = $_SESSION['driver']['name'];
        $uQuery = "UPDATE ".MYSQL_DB.".".MYSQL_TBL_LOCATION." SET location_status = 0".chr(10);
        $uQuery .= "WHERE driver_id = '$driverID'".chr(10);
        $uQuery .= "ORDER BY location_datetime DESC LIMIT 3".chr(10);
        $cMySQLi->query($uQuery);
        session_destroy();
        break;
    case 'DRIVER':
        if(!isset($_SESSION['driver'])) {
            $_SESSION['driver'] = array();
            $_SESSION['driver']['status'] = false;
        }
        echo json_encode($_SESSION['driver']);
        break;

    case 'SAVE_LOCATION':
        $sLatitude = (isset($_POST['latitude']) && !empty($_POST['latitude'])) ? $_POST['latitude'] : "";
        $sLongitude = (isset($_POST['longitude']) && !empty($_POST['longitude'])) ? $_POST['longitude'] : "";
        $vDriver = (isset($_POST['driver_id']) && !empty($_POST['driver_id'])) ? $_POST['driver_id'] : "";
        $iQuery = "INSERT INTO ".MYSQL_TBL_LOCATION." (driver_id, location_latitude, location_longitude) VALUES".chr(10);
        $iQuery .= "('$vDriver', '$sLatitude', '$sLongitude')";
        if($cMySQLi->query($iQuery)) {
            return true;
        } else {
            return false;
        }
        break;
    case 'GET_DRIVERS':
        $colors = array('blue', 'red', 'purple', 'yellow', 'green', 'orange');
        $aLocations = array();
        $sQuery = "SELECT loc.* FROM ".MYSQL_TBL_LOCATION." loc".chr(10);
        $sQuery .= "WHERE loc.location_datetime = (SELECT MAX(loc2.location_datetime) FROM ".MYSQL_TBL_LOCATION." loc2 WHERE loc2.driver_id = loc.driver_id)".chr(10);
        $sQuery .= "AND loc.location_status = 1".chr(10);
        $sQuery .= "GROUP BY loc.driver_id ORDER BY loc.location_datetime DESC";
        $colorCount = 0;
        if($aResult = $cMySQLi->query($sQuery)) {
            while($aRow = $aResult->fetch_array(MYSQLI_ASSOC)) {
                $aLocations[] = $aRow;
            }
            foreach($aLocations as &$thisLoc) {
                if($colorCount == 6) $colorCount = 0;
                $thisLoc['color'] = $colors[$colorCount];
                $colorCount++;
            }
        }
        echo json_encode($aLocations);
        break;
}
?>