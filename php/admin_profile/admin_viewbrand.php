<?php
// DATABASE
require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");
require_once("include/utility/QueryStringBuilder.php");



if(!isset($_SESSION["auth"])){
    // Si rimanda ad una nuova pagina di errore
}

// Template
$admin_viewbrand_page = new Template("skin/admin_profile/admin_viewbrand.html");

//DAO
$factory = new DataLayer(new DB_Connection);
$productorDAO = $factory->getProductorDAO();

if(isset($_REQUEST["productor_id"])){
    
    $productor = $productorDAO->getProductorById($_REQUEST["productor_id"]);

    $admin_viewbrand_page->setContent("productor_id", $productor->getId());
    $admin_viewbrand_page->setContent("productor_name", $productor->getName());
    $admin_viewbrand_page->setContent("productor_logo", $productor->getLogo());

    $admin_viewbrand_page->setContent("producotor_title","productor:");
}
else{
    $admin_viewbrand_page->setContent("productor_logo", "");
    $admin_viewbrand_page->setContent("productor_title","new_productor");
}

?>