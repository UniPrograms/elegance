<?php
// DATABASE
require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");
require_once("include/utility/QueryStringBuilder.php");



if(!isset($_SESSION["auth"])){
    // Si rimanda ad una nuova pagina di errore
}

// Template
$admin_viewcategory_page = new Template("skin/admin_profile/admin_viewcategory.html");

//DAO
$factory = new DataLayer(new DB_Connection);
$categoryDAO = $factory->getCategoryDAO();

if(isset($_REQUEST["category_id"])){
    
    $category = $categoryDAO->getCategoryById($_REQUEST["category_id"]);

    $admin_viewcategory_page->setContent("category_id", $category->getId());
    $admin_viewcategory_page->setContent("category_name", $category->getName());

    $admin_viewcategory_page->setContent("category_title","category:");
}
else{

    $admin_viewcategory_page->setContent("category_title","new category");
}

?>