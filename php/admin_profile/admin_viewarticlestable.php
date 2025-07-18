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


$articles = $articleDAO->getAllArticleByProductId($_REQUEST["product_id"]);

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
