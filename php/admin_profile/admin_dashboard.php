<?php
// DATABASE
require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");
require_once("include/utility/QueryStringBuilder.php");

// Template
$admin_dashboard_page = new Template("skin/admin_profile/admin_dashboard.html");


// DAO
$factory = new DataLayer(new DB_Connection);
$userDAO = $factory->getUserDAO();
$orderDAO = $factory->getOrderDAO();
$articleDAO = $factory->getArticleDAO();




// Numero di utenti registrati
$admin_dashboard_page->setContent("registered_user", $userDAO->getAllUsersCount("UTENTE"));

// Numero di ordini totali
$admin_dashboard_page->setContent("total_order", $orderDAO->getAllOrdersCount());

// Numero di prodotti in stock
$admin_dashboard_page->setContent("total_article_qty", $articleDAO->getArticleTotalQuantity());

// Numero di ordini "IN_LAVORAZIONE"
$admin_dashboard_page->setContent("order_in_progress", $orderDAO->getAllOrdersCount("IN_LAVORAZIONE"));

// Incasso totale del mese corrente
$admin_dashboard_page->setContent("current_revenue", $orderDAO->getOrderRevanueFromMonthAndYear(date("n"), date("Y")));


?>