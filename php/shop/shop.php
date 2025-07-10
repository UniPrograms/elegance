<?php
// DATABASE
require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");
require_once("include/utility/QueryStringBuilder.php");


// DAO 
$factory = new DataLayer(new DB_Connection());
$productDAO = $factory->getProductDAO();
$categoryDAO = $factory->getCategoryDAO();
$sexDAO = $factory->getSexDAO();
$productorDAO = $factory->getProductorDAO();
$colorDAO = $factory->getColorDAO();


// Template
$shop_page = new Template("skin/shop/shop.html");


// Calcolo della paginazione
$current_page = isset($_REQUEST["page"]) ? $_REQUEST["page"] - 1 : 0; 
$limit = 9; // Item che voglio vedere per ogni pagina (rimane costante)
$offset = $current_page * $limit; // Da che punto partire con la paginazione

// Controllo i filtri che sono stati passati
$name = isset($_GET["name"]) ? $_GET["name"] : null;
$category_id = isset($_GET["category_id"]) ? (int) $_GET["category_id"] : null;
$sex_id = isset($_GET["sex_id"]) ? (int) $_GET["sex_id"] : null;
$size_id = isset($_GET["size_id"]) ? (int) $_GET["size_id"] : null;
$productor_id = isset($_GET["productor_id"]) ? (int) $_GET["productor_id"] : null;
$color_id = isset($_GET["color_id"]) ? (int) $_GET["color_id"] : null;
$min_price = isset($_GET["min_price"]) ? (float) $_GET["min_price"] : null;
$max_price = isset($_GET["max_price"]) ? (float) $_GET["max_price"] : null;



// Setto le categorie (e il sesso) per il menu
foreach($sexDAO->getAllSexs() AS $sex){

    $shop_page->setContent("sex_name", $sex->getSex());
    $shop_page->setContent("sex_id", $sex->getId());
    $shop_page->setContent("data_target","#".$sex->getId());
    $shop_page->setContent("data_id", $sex->getId());

    foreach($categoryDAO->getAllCategories() as $category){
        $shop_page->setContent("category_name", $category->getName());
    }
}


// Setto i colori
foreach($colorDAO->getAllColors() as $color){
    $shop_page->setContent("color_value", $color->getId());
    $shop_page->setContent("color_name", $color->getColor());
}


// Setto il brand (produttore)
foreach($productorDAO->getAllProductores() as $productor){
    $shop_page->setContent("productor_value", $productor->getId());
    $shop_page->setContent("productor_name", $productor->getName());
}



// Prendo i prodotti in base ai filtri passati
$products = $productDAO->getProductFiltered($name, $category_id, $sex_id, $color_id, $size_id, $productor_id, $min_price, $max_price, $limit, $offset);

