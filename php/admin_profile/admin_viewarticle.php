<?php
// DATABASE
require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");
require_once("include/utility/QueryStringBuilder.php");



if(!isset($_SESSION["auth"])){
    // Si rimanda ad una nuova pagina di errore
}

// Template
$admin_articles_page = new Template("skin/admin_profile/admin_viewarticle.html");

//DAO
$factory = new DataLayer(new DB_Connection);
$articleDAO = $factory->getArticleDAO();

$articles = $articleDAO->getAllArticles();

foreach($articles as $article){

    $admin_articles_page->setContent("user_id",$user->getId());
    $admin_articles_page->setContent("user_name",$user->toString());
    $admin_articles_page->setContent("user_email",$user->getEmail());
    $admin_articles_page->setContent("user_role",$user->getRole());
    $admin_articles_page->setContent("user_registration_date",$user->getRegistrationDate());


    $admin_articles_page->setContent("user_value", $user->getId());

}

?>