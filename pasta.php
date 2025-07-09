<?php

require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");

$factory = new DataLayer(new DB_Connection());

$productDAO = $factory->getProductDAO();
$products = $productDAO->getProductFiltered();

foreach($products as $p){
    echo $p->getName();
    echo "<br>";
}
echo count($products);

