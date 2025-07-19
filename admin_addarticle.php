<?php 
// Avvio sessione
session_start();

// Templating
require_once("include/template2.inc.php");

// Database
require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");
require_once("include/utility/QueryStringBuilder.php");

// Sidebar
require "php/admin_profile/admin_sidebar.php";
// View articolo
require "php/admin_profile/admin_addarticle.php";

// Template principale admin
$homepage = new Template("skin/admin_profile/admin_index.html");

// Titolo della pagina
$homepage->setContent("title_page", "article details");
$homepage->setContent("sidebar", $admin_sidebar_page->get());
$homepage->setContent("center", $admin_viewarticle_page->get());

$homepage->close();
?> 