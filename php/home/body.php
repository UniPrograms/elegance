<?php
// Database
require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");


// Utility
require_once("include/utility/QueryStringBuilder.php");


// Template
$body_page = new Template("skin/home/body.html");


$factory = new DataLayer(new DB_Connection());
$categoryDAO =  $factory->getCategoryDAO();
$productDAO = $factory->getProductDAO();
$sexDAO = $factory->getSexDAO();

// Id delle categorie
$query_string_builder = new QueryStringBuilder("shop.php");
$query_string_builder->add("category_id", $categoryDAO->getCategoryByName("SHIRT")->getId());
$body_page->setContent("shirt_link", $query_string_builder->build());

$query_string_builder->cleanParams();
$query_string_builder->add("category_id", $categoryDAO->getCategoryByName("SHOES")->getId());
$body_page->setContent("shoes_link", $query_string_builder->build());

$query_string_builder->cleanParams();
$query_string_builder->add("category_id", $categoryDAO->getCategoryByName("ACCESSORIES")->getId());
$body_page->setContent("shoes_link", $query_string_builder->build());


// Slider con i vestiti più venduti
$sexes = ["WOMAN","MAN"];

foreach($sexes as $current_sex){
    $sex= $sexDAO->getSexByName($current_sex);

    // Inserisco il titolo della sezione in base al sesso
    $body_page->setContent("sex_name_title",$sex->getSex());

    foreach($productDAO->getProductPopularBySexId($sex->getId(), 0, 8) as $product){

        // Inserisco i dati del prodotto
        $body_page->setContent("product_copertina",$product->getCopertina());
        $body_page->setContent("product_copertina_hover",$product->getCopertina());
        $body_page->setContent("product_name",$product->getName());
        $body_page->setContent("product_price",$product->getPrice());

        $query_string_builder = new QueryStringBuilder("product.php");
        $query_string_builder->add("product_id", $product->getId());

        $body_page->setContent("product_link", $query_string_builder->build());
    }
}



?>