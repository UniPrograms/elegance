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
$admin_vieworder_page->setContent("order_date",$order->getOrderDate());
$admin_vieworder_page->setContent("order_arrival_date",$order->getStatus());
$admin_vieworder_page->setContent("order_address",$order->getAddress()->toString());
$admin_vieworder_page->setContent("order_payment",$order->getPayment()->getName());
$admin_vieworder_page->setContent("order_number_phone",$order->getAddress()->getPhoneNumber());
$admin_vieworder_page->setContent("order_email",$order->getAddress()->getEmail());
$admin_vieworder_page->setContent("order_customer",$order->getAddress()->getName()." ".$order->getAddress()->getSurname());
$admin_vieworder_page->setContent("order_price",$order->getPrice());

// Setto la select per definire gli stati dell'ordine
$order_status = ["IN_LAVORAZIONE" => "in progress", 
                 "SPEDITO" => "shipped", 
                 "CONSEGNATO" => "delivered"];

foreach($order_status as $key => $value){
    $admin_vieworder_page->setContent("order_status_key", $key);
    $admin_vieworder_page->setContent("order_status_value", $value);

}

?>