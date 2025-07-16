<?php
// Database
require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");
require_once("include/utility/QueryStringBuilder.php");





// Se non Ã¨ stato fatto il login
if(!isset($_SESSION['auth'])) {
    header("Location: login.php");
    exit;
}


// DAO 
$factory = new DataLayer(new DB_Connection());
$cartDAO = $factory->getCartDAO();


// Template
$cart_page = new Template("skin/cart/cart.html");

$cart = $cartDAO->getCartByUserId($_SESSION["id"]);
$cart_items = $cart->getCartItem();


if(count($cart_items) == 0){
    $query_string_builder = new QueryStringBuilder("empty_collection.php");
    $query_string_builder->addEncoded("title_message", "Carrello vuoto.");
    $query_string_builder->addEncoded("text_message", "Non ci sono articoli nel tuo carrello!");
    header("Location: " . $query_string_builder->build());
    exit;
}


// Articoli nel carrello
foreach($cart_items as $item){
    
    $article = $item->getArticle();
    $product = $article->getProduct();

    $cart_page->setContent("product_image",$product->getCopertina());
    $cart_page->setContent("product_name",$product->getName());
    $cart_page->setContent("product_id",$article->getId());
    $cart_page->setContent("color_name",$article->getColor()->getColor());
    $cart_page->setContent("product_brand",$product->getProductor()->getName());
    $cart_page->setContent("product_size",$article->getSize()->getSize());
    $cart_page->setContent("product_color",$article->getColor()->getColor());
    $cart_page->setContent("product_price",$product->getPrice());

    $cart_page->setContent("article_id_to_remove",$item->getId());
    

    $query_string_builder = new QueryStringBuilder("product.php");
    $query_string_builder->add("article_id", $article->getId());
    $cart_page->setContent("product_link", $query_string_builder->build());
}


// Dati del carrello
$cart_page->setContent("total_article",$cart->getSize());
$cart_page->setContent("total_price",$cart->getPrice());

?>