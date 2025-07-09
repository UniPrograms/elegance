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



?>