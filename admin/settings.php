<?php
error_reporting(0);
if(!isset($_COOKIE['Favourite_Beverage_Admin']) || $_COOKIE['Favourite_Beverage_Admin']  != 'ON') {
    header("Location: login.php");
}