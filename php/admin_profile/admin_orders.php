<?php
// DATABASE
require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");
require_once("include/utility/QueryStringBuilder.php");



if(!isset($_SESSION["auth"])){
    // Si rimanda ad una nuova pagina di errore
}

// Template
$admin_orders_page = new Template("skin/admin_profile/admin_orders.html");

//DAO
$factory = new DataLayer(new DB_Connection);
$orderDAO = $factory->getOrderDAO();

if(!isset($_REQUEST["filter_string"])){
    $orders = $orderDAO->getAllOrders();
}
else{
    $strings = explode(' ', $_REQUEST['filter_string']);
    $orders = $orderDAO->getAllOrdersByGenericStrings($strings);
}

foreach($orders as $order){

    $admin_orders_page->setContent("order_id",$order->getId());
    $admin_orders_page->setContent("order_customer",$order->getAddress()->getName()." ".$order->getAddress()->getSurname());
    $admin_orders_page->setContent("order_date",$order->getOrderDate());
    $admin_orders_page->setContent("order_price",$order->getPrice());
    $admin_orders_page->setContent("order_status",$order->getStatus() != "CONSEGNATO" ? $order->getStatus() : $order->getStatus() ." il ".$order->getDeliveryDate());

    $admin_orders_page->setContent("order_value", $order->getId());
}

?>