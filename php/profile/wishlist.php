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

    $wishlist_page->setContent("product_copertina",$product->getCopertina());
    $wishlist_page->setContent("product_name",$product->getName());
    $wishlist_page->setContent("product_category", $product->getCategory()->getName());


    $query_string_builder = new QueryStringBuilder("wishlist_operation.php");
    $query_string_builder->add("delete","1");
    $query_string_builder->add("item_id", $item->getId());
    $wishlist_page->setContent("delete_operation", $query_string_builder->build());
}


?>