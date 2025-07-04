<?php

if(!isset($_SESSION['auth'])) {
    header("Location: login.php");
    exit;
}

$admin_page = new Template("skin/profile/admin_page.html");

?>