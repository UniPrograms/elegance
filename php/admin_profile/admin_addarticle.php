<?php
// DATABASE
require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");
require_once("include/utility/QueryStringBuilder.php");

if(!isset($_SESSION["auth"])){
    header("Location: login.php");
    exit;
}

// Template
$admin_viewarticle_page = new Template("skin/admin_profile/admin_viewarticle.html");

//DAO
$factory = new DataLayer(new DB_Connection);
$articleDAO = $factory->getArticleDAO();
$colorDAO = $factory->getColorDAO();
$sizeDAO = $factory->getSizeDAO();


// Inserisco i valori in base a se il prodotto deve essere inserito o aggiornato
// Se è stato passato un ID
if(isset($_REQUEST["article_id"])){
    // Inizializzo gli array per gestire i colori e le taglie
    $article = $articleDAO->getArticleById($_REQUEST["article_id"]);
    $colors = $colorDAO->getAvailableColorFromProductId($article->getProduct()->getId());
    $sizes = $sizeDAO->getAvailableSizeFromProductId($article->getProduct()->getId());
}
// Se NON è stato passato un ID
else{
    // Inizializzo gli array per gestire i colori e le taglie
    $colors = $colorDAO->getAllColors();
    $sizes = $sizeDAO->getAllSizes();
}


// Inserisco tutte le taglia
foreach($sizes as $size){
    $admin_viewarticle_page->setContent("size_name",$size->getSize());
    $admin_viewarticle_page->setContent("size_value",$size->getId());
}

// Inserisco tutti i colori
foreach($colors as $color){
    $admin_viewarticle_page->setContent("color_name",$color->getColor());
    $admin_viewarticle_page->setContent("color_value",$color->getId());
}

// Inserisco la quantità del prodotto (0 in caso di inserimento)
$admin_viewarticle_page->setContent("article_qty", isset($_REQUEST['article_id']) ? $article->getQuantity() : 0);


// Inserisco i metadati all'interno dei button
$admin_viewarticle_page->setContent("store_button_name", isset($_REQUEST['article_id']) ? "Update" : "Add");

$admin_viewarticle_page->setContent("product_value", $_REQUEST["product_id"]);

?>