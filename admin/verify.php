<?php

if($_POST['username'] == 'admin' && $_POST['password'] == 'admin123456') {
    setcookie('Favourite_Beverage_Admin', 'ON', time() + (86400 * 30), "/");
    header("Location: dashboard.php");
} else {
    header("Location: login.php?error=1");
}