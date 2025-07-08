<?php
// DATABASE
require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");

// Utility
require_once("include/utility/QueryStringBuilder.php");


// Se non è stato fatto il login
if(!isset($_SESSION['auth'])) {
    header("Location: login.php");
    exit;
}


// DAO 
$factory = new DataLayer(new DB_Connection());
$userDAO = $factory->getUserDAO();
$orderDAO = $factory->getOrderDAO();

// Template
$order_history_page = new Template("skin/profile/order_history.html");

$orders = $orderDAO->getOrderByUserId($_SESSION["id"]);

foreach($orders as $order){

    $order_history_page->setContent("order_id",$order->getId());
    $order_history_page->setContent("order_date", $order->getOrderDate());
    $order_history_page->setContent("order_status", $order->getStatus() != "CONSEGNATO" ? $order->getStatus() : $order->getStatus()."(".$order->getDeliveryDate().")");
    $order_history_page->setContent("order_price", $order->getPrice());
    
    $quiery_string_builder = new QueryStringBuilder("order_details.php");
    $quiery_string_builder->add("order_id",$order->getId());

    $order_history_page->setContent("order_link",$quiery_string_builder->build());

    foreach($order->getOrderItem() as $item){
        $product = $item->getArticle()->getProduct();

        $order_history_page->setContent("product_name", $product->getName());
        $order_history_page->setContent("product_category", $product->getCategory()->getName());
        
        $quiery_string_builder = new QueryStringBuilder("product.php");
        $quiery_string_builder->add("product_id",$product->getId());

        $order_history_page->setContent("product_link",$quiery_string_builder->build());     
    }
}


?>