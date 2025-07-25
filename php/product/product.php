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
$articleDAO = $factory->getArticleDAO();


// Se non è stato fornito un ID, allora rimando ad un pagina di errore
if(!isset($_GET["product_id"]) && !isset($_GET["article_id"])){
    $query_string_builder = new QueryStringBuilder("error.php");
    $query_string_builder->add("title_message","Errore del sistema.");
    $query_string_builder->add("text_message","Non è stato possibile caricare il prodotto cercato!");
    header("Location: " . $query_string_builder->build());
    exit;
}

// Dati del prodotto
if(isset($_GET["product_id"])){
    $product = $productDAO->getProductById($_GET["product_id"]);
}else{
    $article = $articleDAO->getArticleById($_GET["article_id"]);
    $product = $article->getProduct();
}


$product_page->setContent("product_name",$product->getName());
$product_page->setContent("product_productor",$product->getProductor()->getName());
$product_page->setContent("product_price",$product->getPrice());
$product_page->setContent("product_description",$product->getDescription());

// Inserisco l'id del prodotto per il campo nascosto
$product_page->setContent("product_id_to_store",$product->getId());



// Inserisco le taglie disponibili del prodotto all'interno della select
$sizes = $sizeDAO->getAvailableSizeFromProductId($product->getId());
foreach($sizes as $size){
    $product_page->setContent("size",$size->getSize());
    $product_page->setContent("value_size", $size->getId());
}


// Inserisco i colori all'interno della select
$colors = $colorDAO->getAvailableColorFromProductId($product->getId());
foreach($colors as $color){
    $product_page->setContent("color",$color->getColor());
    $product_page->setContent("value_color", $color->getId());
}




// Bisogna inserire qui la prima imamgine da presentare, quindi la copertina
$product_page->setContent("product_copertina", $product->getCopertina());

// Inserisco le immagini secondarie da alternare alla copertina
$images = $imageDAO->getAllImagesByProduct($product);
if(count($images) > 0){
    foreach($images as $image){
        $product_page->setContent("other_product_image",$image->getPath());
    }
}
else{
    $product_page->setContent("other_product_image",$product->getCopertina());
}





?>