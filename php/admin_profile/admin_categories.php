<?php
// DATABASE
require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");
require_once("include/utility/QueryStringBuilder.php");


if(!isset($_SESSION["auth"])){
    // Si rimanda ad una nuova pagina di errore
}

// Template
$admin_categories_page = new Template("skin/admin_profile/admin_categories.html");

//DAO
$factory = new DataLayer(new DB_Connection);
$categoryDAO = $factory->getCategoryDAO();


foreach($categoryDAO->getAllCategories() as $category){

    $admin_categories_page->setContent("category_id", $category->getId());
    $admin_categories_page->setContent("category_name",$category->getName());

    $admin_categories_page->setContent("category_value", $category->getId());
}

?>