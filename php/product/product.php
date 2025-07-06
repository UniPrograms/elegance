<?php

// Database
require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");

// Utility
require_once("include/utility/QueryStringBuilder.php");

// Template
$product_page = new Template("skin/product/product.html");

//DAO 
$factory = new DataLayer(new DB_Connection());
$productDAO = $factory->getProductDAO(); 
$sizeDAO = $factory->getSizeDAO();
$colorDAO = $factory->getColorDAO();
$imageDAO = $factory->getImageDAO();

// Se non è stato fornito un ID, allora rimando ad un pagina di errore
if(!isset($GET["product_id"]) && empty($GET["product_id"])){
    // Link per il rimando alla pagina di errore
}

// Dati del prodotto
$product = $productDAO->getProductById($_GET["product_id"]);


$product_page->setContent("product_name",$product->getName());
$product_page->setContent("product_productor",$product->getProductor()->getName());
$product_page->setContent("product_price",$product->getPrice());
$product_page->setContent("product_description",$product->getDescription());

//$product_page->setContent("product_copertina", $product->getCopertina());

// Taglia
$sizes = $sizeDAO->getAllSizes();
foreach($sizes as $size){
    $product_page->setContent("size",$size->getSize());
}

// Color
$colors = $colorDAO->getAllColors();
foreach($colors as $color){
    $product_page->setContent("color",$color->getColor());
}


// Immagini secondarie del prodotto
$images = $imageDAO->getImageByProduct($product);
foreach($images as $image){
    $product_page->setContent("product_image",$image->getPath());
}

// Per aggiungere alla wishlist
$query_string_builder = new QueryStringBuilder("wishlist.php");

$product_page->setContent("wishlist_link", $query_string_builder->build());

?>