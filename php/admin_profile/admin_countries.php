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
$admin_countries_page = new Template("skin/admin_profile/admin_countries.html");

//DAO
$factory = new DataLayer(new DB_Connection);
$countryDAO = $factory->getCountryDAO();

if(!isset($_REQUEST["filter_string"])){
    $countries = $countryDAO->getAllCountries();
}
else{
    $countries = $countryDAO->getCategoriesByGenericString($_REQUEST['filter_string']);
}



foreach($countries as $country){

    $admin_countries_page->setContent("country_id", $country->getId());
    $admin_countries_page->setContent("country_name",$country->getName());

    $admin_countries_page->setContent("country_value", $country->getId());
}

?>