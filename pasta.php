<?php

require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");

$factory = new DataLayer(new DB_Connection());

$cartDAO = $factory->getCartDAO();

