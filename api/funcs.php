<?php
include_once 'constants.php';	// Constant Values.

$sServer = MYSQL_HOST;	$sUsername = MYSQL_USER;	$sPassword = MYSQL_PASS;

$cMySQLi = null;	// MySQLi Connector.
$sLastDB = "";		// Last DB Connected to.

/**
 * @desc Connect to the MySQL Server (if required). No DB specified.
 * @return none
 */
function connDB()	{
    global $sServer, $sUsername, $sPassword, $cMySQLi;
    if (($cMySQLi != null) && ($cMySQLi->server_version != null))	{
        mysqli_clean_connection();
    }	else	{
        //$cMySQLi = new mysqli($sServer, $sUsername, $sPassword);
        $cMySQLi = mysqli_init();
        mysqli_options($cMySQLi, MYSQLI_OPT_LOCAL_INFILE, true);
        mysqli_real_connect($cMySQLi, $sServer, $sUsername, $sPassword, MYSQL_DB);
        if ($cMySQLi->connect_error)	die('Could not connect to database becoz '.mysqli_connect_error());
    }
}

/**
 * @desc Switch/Select DB in current Connection.
 * @param string $sDBName
 * @return none
 */
function selDB($sDBName = "test")	{
    $bNeedToChange = false;
    global $bDebug, $cMySQLi, $sLastDB;	connDB();	if ($bDebug)	echo "Switching DB!<br />";
    if ($sLastDB != $sDBName)	{	$sLastDB = $sDBName;	if (!$cMySQLi->select_db($sDBName))	die('Could not attach to DB becoz '.$cMySQLi->error);	}
    else	{	if ($bDebug)	echo "Already This DB!<br />";	}
}

function STX_DB()	{	selDB(MYSQL_DB);	}

function mysqli_clean_connection()	{
    global $bDebug, $cMySQLi;
    if ($bDebug)	echo "Cleaning Connection...<br />";
    while (@mysqli_more_results($cMySQLi))	{
        if (@mysqli_next_result($cMySQLi))	{
            $result = @mysqli_use_result($cMySQLi);
            @mysqli_free_result($result);
        }
    }
}

function fCleanMySQL($vVar)	{
    $vVar = str_replace("'", "\'", $vVar);
    $vVar = str_replace("#", "", $vVar);
    //$vVar = str_replace("\\", "\\\\");
    return $vVar;
}

function fPrintR($aArray, $sName = "")	{
    if ($sName != "")	echo "Array '$sName' ";
    $theCount = count($aArray);
    echo "has (".$theCount." elements): -<br />";
    if ($theCount > 0)	echo "<pre>".print_r($aArray, true)."</pre><br />";
}
?>
