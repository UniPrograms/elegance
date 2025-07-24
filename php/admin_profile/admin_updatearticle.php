<?php
require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");
require_once("include/utility/QueryStringBuilder.php");

if(!isset($_SESSION["auth"])){
    header("Location: login.php");
    exit;
}

$admin_updatearticle_page = new Template("skin/admin_profile/admin_updatearticle.html");

$factory = new DataLayer(new DB_Connection);
$articleDAO = $factory->getArticleDAO();

$article = $articleDAO->getArticleByIdFullQuantity($_REQUEST["article_id"]);
$min_quantity = $articleDAO->getArticleQuantityInCarts($article->getId());

$admin_updatearticle_page->setContent("article_product_name", $article->getProduct()->getName());
$admin_updatearticle_page->setContent("size_name", $article->getSize()->getSize());
$admin_updatearticle_page->setContent("size_id", $article->getSize()->getId());
$admin_updatearticle_page->setContent("color_name", $article->getColor()->getColor());
$admin_updatearticle_page->setContent("color_id", $article->getColor()->getId());
$admin_updatearticle_page->setContent("article_quantity", $article->getQuantity());
$admin_updatearticle_page->setContent("product_value", $_REQUEST["product_id"]);
$admin_updatearticle_page->setContent("article_min_quantity", $min_quantity);




?>




