<?php
// DATABASE
require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");
require_once("include/utility/QueryStringBuilder.php");



if(!isset($_SESSION["auth"])){
    // Si rimanda ad una nuova pagina di errore
}

// Template
$admin_viewproduct_page = new Template("skin/admin_profile/admin_viewproduct.html");

//DAO
$factory = new DataLayer(new DB_Connection);
$productDAO = $factory->getProductDAO();


$product = $productDAO->getProductById($_REQUEST["product_id"]);


// Inserimento all'interno del button per andare alla gestione degli articoli
$admin_viewproduct_page->setContent("product_value",$product->getId());


?>