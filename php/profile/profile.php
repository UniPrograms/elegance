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
$profile_page = new Template("skin/profile/profile.html");


$user = $userDAO->getUserById($_SESSION["id"]);

$profile_page->setContent("user_name", $user->toString());
$profile_page->setContent("user_email", $user->getEmail());

$orders = $orderDAO->getOrderByUserId($_SESSION["id"]);

foreach($orders as $order){
    
    $profile_page->setContent("order_id",$order->getId());
    $profile_page->setContent("order_date", $order->getOrderDate());
    $profile_page->setContent("order_status", $order->getStatus() != "CONSEGNATO" ? $order->getStatus() : $order->getStatus()."(".$order->getDeliveryDate().")");
    $profile_page->setContent("order_price", "da definire con una query");
    
    $quiery_string_builder = new QueryStringBuilder("order_details.php");
    $quiery_string_builder->add("order_id",$order->getId());

    $profile_page->setContent("order_link",$quiery_string_builder->build());

    foreach($order->getOrderItem() as $item){
        $product = $item->getArticle()->getProduct();

        $profile_page->setContent("product_name", $product->getName());
        $profile_page->setContent("product_category", $product->getCategory()->getName());
        
        $quiery_string_builder = new QueryStringBuilder("product.php");
        $quiery_string_builder->add("product_id",$product->getId());

        $profile_page->setContent("product_link",$quiery_string_builder->build());

        
    }
}


?>