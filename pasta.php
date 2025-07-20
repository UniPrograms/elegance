<?php

require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");
require_once("include/utility/AuthManager.php");

$factory = new DataLayer(new DB_Connection());


echo AuthManager::encryptPasswordSHA("gab");
echo "<br>";
echo AuthManager::encryptPasswordSHA("lor");
echo "<br>";
echo AuthManager::encryptPasswordSHA("lui");
echo "<br>";
echo AuthManager::encryptPasswordSHA("ale");
echo "<br>";




