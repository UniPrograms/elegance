<?php

// Database
require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");
require_once("include/utility/QueryStringBuilder.php");


// Template
$header = new Template("skin/home/header.html");

$factory = new DataLayer(new DB_Connection());
$categorie = $factory->getCategoryDAO()->getAllCategories();
$sex = $factory->getSexDAO();


// Woman column
foreach ($categorie as $categoria) {
    
    // Inserisco il nome della categoria
    $header->setContent("category_name_woman", $categoria->getName());
    
    // Costruisco la query string
    $query_string_builder = new QueryStringBuilder();
    $query_string_builder->add("category_id",$categoria->getId());
    $query_string_builder->add("sex_id",$sex->getSexByName("WOMAN")->getId());
    
    $header->setContent("shop_link_woman","shop.php" . $query_string_builder->build());
}



// Man column
foreach ($categorie as $categoria) {
    
    // Inserisco il nome della categoria
    $header->setContent("category_name_man", $categoria->getName());
    
    // Costruisco la query string
    $query_string_builder = new QueryStringBuilder();
    $query_string_builder->add("category_id",$categoria->getId());
    $query_string_builder->add("sex_id",$sex->getSexByName("MAN")->getId());
    
    $header->setContent("shop_link_man","shop.php" . $query_string_builder->build());
}

// Kid column
foreach ($categorie as $categoria) {
    
    // Inserisco il nome della categoria
    $header->setContent("category_name_kid", $categoria->getName());
    
    // Costruisco la query string
    $query_string_builder = new QueryStringBuilder();
    $query_string_builder->add("category_id",$categoria->getId());
    $query_string_builder->add("sex_id",$sex->getSexByName("KID")->getId());
    
    $header->setContent("shop_link_kid","shop.php" . $query_string_builder->build());
}

