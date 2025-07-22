<?php
// DATABASE
require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");
require_once("include/utility/QueryStringBuilder.php");


// Template
$admin_brands_page = new Template("skin/admin_profile/admin_brands.html");

//DAO
$factory = new DataLayer(new DB_Connection);
$productorDAO = $factory->getProductorDAO();


foreach($productorDAO->getAllProductores() as $productor){

    $admin_brands_page->setContent("brand_id", $productor->getId());
    $admin_brands_page->setContent("brand_name",$productor->getName());

    $admin_brands_page->setContent("brand_value", $productor->getId());
}

?>