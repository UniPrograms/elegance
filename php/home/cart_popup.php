<?php

// Database
require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");


// Template
$cart_popup = new Template("skin/home/cart_popup.html");


// DAO
$factory = new DataLayer(new DB_Connection());
$cartDAO = $factory->getCartDAO();
$cartItemDAO = $factory->getCartItemDAO();
$articleDAO = $factory->getArticleDAO();


// Cart dell'utente 
$user_cart = $cartDAO->getCartByUserId(1);
$cart_item = $cartItemDAO->getCartItemByCart($user_cart);


// Scorro tutti quanti gli articoli all'interno del carrello
foreach($cart_item as $single_item){
    $article = $single_item->getArticle();
    $product = $article->getProduct();

    $cart_popup->setContent("product_image", $product->getCopertina());
    $cart_popup->setContent("product_productor", $product->getProductor()->getName());
    $cart_popup->setContent("product_name", $product->getName());
    $cart_popup->setContent("product_price", $product->getPrice());
    $cart_popup->setContent("size",$article->getSize()->getSize());
    $cart_popup->setContent("color",$article->getColor()->getColor());
}





?>