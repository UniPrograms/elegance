<?php
// DATABASE
require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");
require_once("include/utility/QueryStringBuilder.php");



if(!isset($_SESSION["auth"])){
    header("Location: login.php");
    exit;
}

// Template
$admin_viewcountry_page = new Template("skin/admin_profile/admin_viewcountry.html");

//DAO
$factory = new DataLayer(new DB_Connection);
$countryDAO = $factory->getCountryDAO();

if(isset($_REQUEST["country_id"])){
    
    $country = $countryDAO->getCountryById($_REQUEST["country_id"]);

    $admin_viewcountry_page->setContent("country_id", $country->getId());
    $admin_viewcountry_page->setContent("country_name", $country->getName());

    $admin_viewcountry_page->setContent("country_title","country:");

}
else{

    $admin_viewcountry_page->setContent("country_title","new country");
}

?>