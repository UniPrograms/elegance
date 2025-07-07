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


// Se non è stato passato l'id dell'ordine
if(!isset($_GET["order_id"])){
    // Reindirizzamento ad una pagina di errore
}


// DAO 
$factory = new DataLayer(new DB_Connection());
$orderDAO = $factory->getOrderDAO();
$orderItemDAO = $factory->getOrderItemDAO();

// Template
$order_details_page = new Template("skin/profile/order_details.html");

$order = $orderDAO->getOrderByIdAndUserId($_GET["order_id"],$_SESSION["id"]);

// Dati dell'ordine
$order_details_page->setContent("order_id",$order->getId());
$order_details_page->setContent("order_date",$order->getOrderDate());
$order_details_page->setContent("order_status",$order->getStatus() != "CONSEGNATO" ? $order->getStatus() : $order->getStatus() ."(".$order->getDeliveryDate().")");
$order_details_page->setContent("order_total_price",$order->getPrice());
$order_details_page->setContent("order_delivery",$order->getDelivery()->getNAme());
$order_details_page->setContent("order_payment",$order->getPayment()->getName());
$order_details_page->setContent("order_recipient",$order->getUser()->toString());
$order_details_page->setContent("order_address",$order->getAddress()->toString());



// Articoli dell'ordine
$order_items = $order->getOrderItem();

foreach($order_items as $item){
    $product = $item->getArticle()->getProduct();
    $order_details_page->setContent("product_copertina",$product->getCopertina());
    $order_details_page->setContent("product_name",$product->getName());
    $order_details_page->setContent("product_category",$product->getCategory()->getName());

    $query_string_builder = new QueryStringBuilder("product.php");
    $query_string_builder->add("product_id", $product->getId());
    $order_details_page->setContent("product_link",$query_string_builder->build());

}


?>