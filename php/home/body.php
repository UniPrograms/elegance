<?php
// Database
require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");


// Utility
require_once("include/utility/QueryStringBuilder.php");


// Template
$body = new Template("skin/home/body.html");


$factory = new DataLayer(new DB_Connection());
$categoryDAO =  $factory->getCategoryDAO();

// Id delle categorie
$query_string_builder = new QueryStringBuilder("shop.php");
$query_string_builder->add("category_id", $categoryDAO->getCategoryByName("SHIRT")->getId());
$body->setContent("shirt_link", $query_string_builder->build());

$query_string_builder->clean();
$query_string_builder->add("category_id", $categoryDAO->getCategoryByName("SHOES")->getId());
$body->setContent("shoes_link", $query_string_builder->build());


$query_string_builder->clean();
$query_string_builder->add("category_id", $categoryDAO->getCategoryByName("ACCESSORIES")->getId());
$body->setContent("shoes_link", $query_string_builder->build());



?>