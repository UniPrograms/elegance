<?php
// DATABASE
require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");
require_once("include/utility/QueryStringBuilder.php");



if(!isset($_SESSION["auth"])){
    // Si rimanda ad una nuova pagina di errore
}

// Template
$admin_products_page = new Template("skin/admin_profile/admin_products.html");

//DAO
$factory = new DataLayer(new DB_Connection);
$productDAO = $factory->getProductDAO();

$products = $productDAO->getAllProduct();

foreach($products as $product){

    $admin_products_page->setContent("product_id",$product->getId());
    $admin_products_page->setContent("product_name",$product->getName());
    $admin_products_page->setContent("product_category",$product->getCategory()->getName());
    $admin_products_page->setContent("product_brand",$product->getProductor()->getName());
    $admin_products_page->setContent("product_price",$product->getPrice());

    $admin_products_page->setContent("product_value",$product->getId());
}

?>