<?php

// DATABASE
require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");


if(!isset($_SESSION['auth'])) {
    header("Location: login.php");
    exit;
}

// DAO 
$factory = new DataLayer(new DB_Connection());
$wishlistDAO = $factory->getWishlistDAO();
$wishlistItemDAO = $factory->getWishlistItemDAO();

// Template
$wishlist_page = new Template("skin/profile/wishlist.html");


$wishlist = $wishlistDAO->getWishlistByUserId($_SESSION["id"]);

$wishlist_items = $wishlistItemDAO->getWishlistItemByWishlist($wishlist);


foreach($wishlist_items as $item){
    $article = $item->getArticle();
    $product = $article->getProduct();

    // Dati del prodotto
    $wishlist_page->setContent("product_copertina",$product->getCopertina());
    $wishlist_page->setContent("product_name",$product->getName());
    $wishlist_page->setContent("product_category", $product->getCategory()->getName());

    // Consente di andare alla pagina specifica del prodotto
    $query_string_builder = new QueryStringBuilder("product.php");
    $query_string_builder->add("product_id", $product->getId());
    $wishlist_page->setContent("product_link",$query_string_builder->build());

    // Consente di settare la query string per eliminare un prodotto dalla wishlist
    $wishlist_page->setContent("delete_ref", "wishlist_operation.php");
    $wishlist_page->setContent("optional_param_delete", "delete");
    $wishlist_page->setContent("value_article_delete", $item->getId());

    // Consente di spostare un prodotto dalla wishlist al carrello
    $wishlist_page->setContent("move_ref","wishlist_operation.php");
    $wishlist_page->setContent("optional_param_move", "move");
    $wishlist_page->setContent("value_article_move",$item->getId());
    
    
}


?>