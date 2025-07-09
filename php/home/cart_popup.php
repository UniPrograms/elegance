<?php

// Database
require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");

// Se la sessione non è attiva
if (!isset($_SESSION["auth"])) { $cart_popup_page = new Template(""); }

// Se la sessione è attiva
else {
    
    // Template
    $cart_popup_page = new Template("skin/home/cart_popup.html");

    // DAO
    $factory = new DataLayer(new DB_Connection());
    $cartDAO = $factory->getCartDAO();

    // Carrello dell'utente
    $user_cart = $cartDAO->getCartByUserId($_SESSION["id"]);


    // Scorro tutti quanti gli articoli all'interno del carrello
    foreach ($user_cart->getCartItem() as $single_item) {
        
        $article = $single_item->getArticle();
        $product = $article->getProduct();
        
        $cart_popup_page->setContent("product_image", $product->getCopertina());
        $cart_popup_page->setContent("product_productor", $product->getProductor()->getName());
        $cart_popup_page->setContent("product_name", $product->getName());
        $cart_popup_page->setContent("product_price", $product->getPrice());
        $cart_popup_page->setContent("size", $article->getSize()->getSize());
        $cart_popup_page->setContent("color", $article->getColor()->getColor());
    }

    // Prezzo totale del carrello
    $cart_popup_page->setContent("cart_total_price", $user_cart->getPrice());
    $cart_popup_page->setContent("cart_total_items", $user_cart->getSize());
}
