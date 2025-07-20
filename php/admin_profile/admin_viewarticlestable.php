<?php
// DATABASE
require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");
require_once("include/utility/QueryStringBuilder.php");

if(!isset($_SESSION["auth"])){
    // Si rimanda ad una nuova pagina di errore
}

// Template
$admin_viewarticlestable_page = new Template("skin/admin_profile/admin_viewarticlestable.html");

//DAO
$factory = new DataLayer(new DB_Connection);
$articleDAO = $factory->getArticleDAO();



// Ottieni gli articoli solo se product_id è valido
if (isset($_REQUEST["product_id"]) && is_numeric($_REQUEST["product_id"]) && $_REQUEST["product_id"] > 0) {
    $articles = $articleDAO->getAllArticleByFullQuantityProductId((int)$_REQUEST["product_id"]);
} else {
    $articles = [];
}

foreach($articles as $article){
    $product = $article->getProduct();

    $admin_viewarticlestable_page->setContent("article_id", $article->getId());
    $admin_viewarticlestable_page->setContent("article_product_name", $product->getName());
    $admin_viewarticlestable_page->setContent("article_size", $article->getSize()->getSize());
    $admin_viewarticlestable_page->setContent("article_color", $article->getColor()->getColor());
    $admin_viewarticlestable_page->setContent("article_quantity", $article->getQuantity());

    $admin_viewarticlestable_page->setContent("article_value", $article->getId());
}

?>
