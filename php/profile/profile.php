<?php

if(!isset($_SESSION['auth'])) {
    header("Location: login.php");
    exit;
}

$profile_page = new Template("skin/profile/profile.html");

?>