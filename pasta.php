<?php

require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");

$factory = new DataLayer(new DB_Connection());

$productDAO = $factory->getProductDAO();


$donna = $productDAO->getProductPopularBySexId(1, 0, 8);
$uomo = $productDAO->getProductPopularBySexId(2, 0, 8);
$uomo = $productDAO->getProductPopular(0, 8);

echo count($donna);
echo count($uomo);