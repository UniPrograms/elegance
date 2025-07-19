<?php
// DATABASE
require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");
require_once("include/utility/QueryStringBuilder.php");



if(!isset($_SESSION["auth"])){
    // Si rimanda ad una nuova pagina di errore
}

// Template
$admin_viewproduct_page = new Template("skin/admin_profile/admin_viewproduct.html");

//DAO
$factory = new DataLayer(new DB_Connection);
$productDAO = $factory->getProductDAO();
$categoryDAO = $factory->getCategoryDAO();
$sexDAO = $factory->getSexDAO();
$productorDAO = $factory->getProductorDAO();

// Inizializzo le categorie
foreach($categoryDAO->getAllCategories() as $category){
    $admin_viewproduct_page->setContent("category_id", $category->getId());
    $admin_viewproduct_page->setContent("category_name", $category->getName());
}

// Inizializzo i sessi
foreach($sexDAO->getAllSexs() as $sex){
    $admin_viewproduct_page->setContent("sex_id", $sex->getId());
    $admin_viewproduct_page->setContent("sex_name", $sex->getSex());
}

// Inizializzo i produttori
foreach($productorDAO->getAllProductores() as $productor){
    $admin_viewproduct_page->setContent("brand_id", $productor->getId());
    $admin_viewproduct_page->setContent("brand_name", $productor->getName());
}

// Se il prodotto è stato passato, allora inizializzo i dati del prodotto
if(isset($_REQUEST["product_id"])){
    // Dati specifici del prodotto
    $product = $productDAO->getProductById((int)$_REQUEST["product_id"]);
    $admin_viewproduct_page->setContent("product_id", $product->getId());
    $admin_viewproduct_page->setContent("product_name", $product->getName());
    $admin_viewproduct_page->setContent("product_brand", $product->getProductor()->getName());
    $admin_viewproduct_page->setContent("product_price", $product->getPrice());
    $admin_viewproduct_page->setContent("product_description", $product->getDescription());

    // Titolo della pagina
    $admin_viewproduct_page->setContent("product_title", "product:");

    // Valore del prodotto per andare nella pagina degli articoli
    $admin_viewproduct_page->setContent("product_value", $product->getId());
}else{
    // Titolo della pagina
    $admin_viewproduct_page->setContent("product_title", "new product");
    // Valore del prodotto per andare nella pagina degli articoli
    $admin_viewproduct_page->setContent("product_value", "");
}

// Inserimento all'interno del button per andare alla gestione degli articoli




?>