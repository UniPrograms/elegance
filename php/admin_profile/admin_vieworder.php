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
$admin_vieworder_page = new Template("skin/admin_profile/admin_vieworder.html");

//DAO
$factory = new DataLayer(new DB_Connection);
$orderDAO = $factory->getOrderDAO();

$order = $orderDAO->getOrderById($_REQUEST["order_id"]);


// Setto i dati dell'ordine

$admin_vieworder_page->setContent("order_id",$order->getId());
$admin_vieworder_page->setContent("order_date",$order->getOrderDate());

// Gestione data di arrivo: se null o vuota, mostra stringa vuota, altrimenti mostra la data
$deliveryDate = $order->getDeliveryDate();
$admin_vieworder_page->setContent("order_arrival_date", ($deliveryDate == null || $deliveryDate == "") ? "" : $deliveryDate);

$admin_vieworder_page->setContent("order_address",$order->getAddress()->toString());
$admin_vieworder_page->setContent("order_payment",$order->getPayment()->getName());
$admin_vieworder_page->setContent("order_number_phone",$order->getAddress()->getPhoneNumber());
$admin_vieworder_page->setContent("order_email",$order->getAddress()->getEmail());
$admin_vieworder_page->setContent("order_customer",$order->getAddress()->getName()." ".$order->getAddress()->getSurname());
$admin_vieworder_page->setContent("order_price",$order->getPrice());
$admin_vieworder_page->setContent("order_address_nazione", $order->getAddress()->getNazione());
$admin_vieworder_page->setContent("order_address_citta", $order->getAddress()->getCitta());
$admin_vieworder_page->setContent("order_address_via", $order->getAddress()->getVia());
$admin_vieworder_page->setContent("order_address_civico", $order->getAddress()->getCivico());
$admin_vieworder_page->setContent("order_address_cap", $order->getAddress()->getCAP());
$admin_vieworder_page->setContent("order_address_provincia", $order->getAddress()->getProvincia());

// Setto la select per definire gli stati dell'ordine
$order_status = ["IN_LAVORAZIONE" => "in progress", 
                 "SPEDITO" => "shipped", 
                 "CONSEGNATO" => "delivered"];

foreach($order_status as $key => $value){
    $admin_vieworder_page->setContent("order_status_key", $key);
    $admin_vieworder_page->setContent("order_status_value", $value);
    
    // Seleziona automaticamente lo stato corrente dell'ordine
    if($key == $order->getStatus()){
        $admin_vieworder_page->setContent("order_status_selected", "selected");
    } else {
        $admin_vieworder_page->setContent("order_status_selected", "");
    }
}

?>