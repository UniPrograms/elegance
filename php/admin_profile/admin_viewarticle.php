<?php
// DATABASE
require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");
require_once("include/utility/QueryStringBuilder.php");

if(!isset($_SESSION["auth"])){
    // Si rimanda ad una nuova pagina di errore
}

// Template
$admin_viewarticle_page = new Template("skin/admin_profile/admin_viewarticle.html");

//DAO
$factory = new DataLayer(new DB_Connection);



// Sezione degli articoli che già esistono


?>