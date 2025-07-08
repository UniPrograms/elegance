<?php
// Database
require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");

// Utility
require_once("include/utility/QueryStringBuilder.php");

// Model
require_once("include/model/Order.php");

// Se la sessione non è attiva
if(!isset($_SESSION["auth"])){
    // Reindirizzamento di una pagina di errore o login
}


//DAO 
$factory = new DataLayer(new DB_Connection());
$orderDAO = $factory->getOrderDAO();
$addressDAO = $factory->getAddressDAO();
$paymentDAO = $factory->getPaymentDAO();
$userDAO = $factory->getUserDAO();
$deliveryDAO = $factory->getDeliveryDAO();




// Inserimento di un nuovo ordine
if(isset($_REQUEST["store"])){

    // Controllo se tutti i campi necessari sono settati
    if(!(
        isset($_REQUEST["firstname"]) &&
        isset($_REQUEST["lastname"]) &&
        isset($_REQUEST["email_address"]) &&
        isset($_REQUEST["country"]) &&
        isset($_REQUEST["street_address"]) &&
        isset($_REQUEST["postcode"]) &&
        isset($_REQUEST["city"]) &&
        isset($_REQUEST["state"]) &&
        isset($_REQUEST["phone_number"]) &&
        isset($_REQUEST["payment_method"]) &&
        isset($_REQUEST["total_items"]) &&
        isset($_REQUEST["total_price"]) 
    )){
        // Rimanda ad una pagina di errore
    }


    // Creo l'indirizzo per il nuovo indirizzo
    $new_address = new Address();
    $new_address->setNazione($_REQUEST["country"]);
    $new_address->setCitta($_REQUEST["city"]);
    $new_address->setVia($_REQUEST["street_address"]);
    $new_address->setProvincia($_REQUEST["state"]);
    $new_address->setCAP($_REQUEST["postcode"]);
    $new_address->setName($_REQUEST["firstname"]);
    $new_address->setSurname($_REQUEST["lastname"]);
    $new_address->setEmail($_REQUEST["email_address"]);
    if(isset($_REQUEST["phone_number"]) && !empty($_REQUEST["phone_number"])) {$new_address->setPhoneNumber($_REQUEST["phone_number"]);}
    if(isset($_REQUEST["civic_number"]) && !empty($_REQUEST["civic_number"])) {$new_address->setCivico($_REQUEST["civic_number"]);}

    // Inserisco il nuovo indirizzo
    $new_address = $addressDAO->storeAddress($new_address);

    // Se ci sono stati errori durante l'inserimento dell'indirizzo
    if($new_address == null){
        // Rimando ad una pagina di errore
    }


    // Creo il nuovo ordine
    $new_order = new Order();
    $new_order->setAddress($new_address);
    $new_order->setPayment($paymentDAO->getPaymentById($_REQUEST["payment_method"]));
    $new_order->setUser($userDAO->getUserById($_SESSION["id"]));
    $new_order->setDelivery($deliveryDAO->getDeliveryById(1));  

    // Inserisco il nuovo ordine
    $new_order = $orderDAO->storeOrder($new_order);

    // Se ci sono stati errori durante l'inserimento dell'ordine
    if($new_order == null){
        // Rimando ad una pagina di errore
    }

    $query_string_builder = new QueryStringBuilder("order_details.php");
    $query_string_builder->add("order_id", $new_order->getId());
    header("Location: ". $query_string_builder->build());

}
// Altrimenti
else{

}



?>