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

// Inserisco l'id del prodotto per il campo nascosto
$product_page->setContent("product_id_to_store",$product->getId());



// Inserisco le taglie disponibili del prodotto all'interno della select
$sizes = $sizeDAO->getAvailableSizeFromProductId($_GET["product_id"]);
foreach($sizes as $size){
    $product_page->setContent("size",$size->getSize());
    $product_page->setContent("value_size", $size->getId());
}


// Inserisco i colori all'interno della select
$colors = $colorDAO->getAvailableColorFromProductId($_GET["product_id"]);
foreach($colors as $color){
    $product_page->setContent("color",$color->getColor());
    $product_page->setContent("value_color", $color->getId());
}







// Bisogna inserire qui la prima imamgine da presentare, quindi la copertina
//$product_page->setContent("product_copertina", $product->getCopertina());

// Inserisco le immagini secondarie da alternare alla copertina
$images = $imageDAO->getImageByProduct($product);
foreach($images as $image){
    $product_page->setContent("product_image",$image->getPath());
}






?>