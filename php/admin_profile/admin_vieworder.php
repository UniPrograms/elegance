<?php
// DATABASE
require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");
require_once("include/utility/QueryStringBuilder.php");



if(!isset($_SESSION["auth"])){
    // Si rimanda ad una nuova pagina di errore
}

// Template
$admin_vieworder_page = new Template("skin/admin_profile/admin_vieworder.html");

//DAO
$factory = new DataLayer(new DB_Connection);
$orderDAO = $factory->getOrderDAO();

$order = $orderDAO->getOrderById($_REQUEST["order_id"]);


// Setto i fati dell'ordine
$admin_vieworder_page->setContent("order_id",$order->getId());
$admin_vieworder_page->setContent("order_creation_date",$order->getId());
$admin_vieworder_page->setContent("order_delivery_date",$order->getId());
$admin_vieworder_page->setContent("order_country",$order->getId());
$admin_vieworder_page->setContent("order_town",$order->getId());
$admin_vieworder_page->setContent("order_address",$order->getId());
$admin_vieworder_page->setContent("order_cap",$order->getId());
$admin_vieworder_page->setContent("order_status",$order->getId());
$admin_vieworder_page->setContent("order_payment",$order->getId());
$admin_vieworder_page->setContent("order_number_phone",$order->getId());
$admin_vieworder_page->setContent("order_email",$order->getId());

?>