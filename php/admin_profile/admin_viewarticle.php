<?php
// DATABASE
require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");
require_once("include/utility/QueryStringBuilder.php");



if(!isset($_SESSION["auth"])){
    // Si rimanda ad una nuova pagina di errore
}

// Template
$admin_viewarticle_page = new Template("skin/admin_profile/admin_viewarticle.html");

//DAO
$factory = new DataLayer(new DB_Connection);
$articleDAO = $factory->getArticleDAO();
$colorDAO = $factory->getColorDAO();
$sizeDAO = $factory->getSizeDAO();


// SEZIONE: AGGIUNGI PRODOTTO

// Inserisco tutte le taglie
foreach($sizeDAO->getAllSizes() AS $size){
    $admin_viewarticle_page->setContent("size_name",$size->getSize());
    $admin_viewarticle_page->setContent("size_value", $size->getId());
}

// Inserisco tutti colori
foreach($colorDAO->getAllColors() AS $color){
    $admin_viewarticle_page->setContent("color_name",$color->getColor());
    $admin_viewarticle_page->setContent("color_value", $color->getId());
}


// SEZIONE: MODIFICA/RIMOZIONE PRODOTTO

// Modifica 
foreach($sizeDAO->getAvailableSizeFromProductId($_REQUEST["product_id"]) as $size){
    $admin_viewarticle_page->setContent("size_name_available",$size->getSize());
    $admin_viewarticle_page->setContent("size_value_available", $size->getId());
}

// Inserisco tutti colori
foreach($colorDAO->getAvailableColorFromProductId($_REQUEST["product_id"]) AS $color){
    $admin_viewarticle_page->setContent("color_name_available",$color->getColor());
    $admin_viewarticle_page->setContent("color_value_available", $color->getId());
}




// Sezione degli articoli che già esistono


?>