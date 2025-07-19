<?php
// Database
require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");
require_once("include/utility/QueryStringBuilder.php");
require_once("include/utility/AjaxResponse.php");
require_once("include/model/Order.php");
require_once("include/model/OrderItem.php");

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
$cartDAO = $factory->getCartDAO();
$orderItemDAO = $factory->getOrderItemDAO();
$cartItemDAO = $factory->getCartItemDAO();




// Modifica dello stato dell'ordine da parte dell'admin
if(isset($_REQUEST["operation"]) && $_REQUEST["operation"] == "admin-update-state"){

    // Se non sono stati forniti i dati necessari
    if(!(isset($_REQUEST["order_id"]) && isset($_REQUEST["order_status"]))){
        echo AjaxResponse::genericServerError()->build();
        exit;
    }

    // Effettuo l'aggiornamento dell stato nel db
    $order = $orderDAO->getOrderById($_REQUEST["order_id"]);

    $order->setStatus($_REQUEST["order_status"]);


    $order = $orderDAO->storeOrder($order);

    // Se qualcosa è andato male
    if($order == null){
        echo AjaxResponse::genericServerError()->build();
        exit;
    }

    // Se tutto è andato bene
    echo AjaxResponse::okNoContent()->build();
    exit;

}
// Inserimento di un nuovo ordine da parte dell'utente
else if(isset($_REQUEST["store"])){

    // Se i campi necessari non sono settati tutti, rimanda ad un errore
    if(!(isset($_REQUEST["firstname"]) && isset($_REQUEST["lastname"]) && isset($_REQUEST["email_address"]) &&
        isset($_REQUEST["country"]) && isset($_REQUEST["street_address"]) && isset($_REQUEST["postcode"]) &&
        isset($_REQUEST["city"]) && isset($_REQUEST["state"]) && isset($_REQUEST["payment_method"]) &&
        isset($_REQUEST["total_items"]) && isset($_REQUEST["total_price"]) )){
        header("Location: error.php");
    }


    // Creo in il nuovo indirizzo e lo inserisco all'interno del db
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


    $new_address = $addressDAO->storeAddress($new_address); // Inserisco nel db

    if($new_address === null || $new_address->getId() === null){ header("Location: error.php"); } // Se non è avvenuto l'inserimento



    // Creo il nuovo ordine e lo inserisco all'interno del db
    $new_order = new Order();
    $new_order->setAddress($new_address);
    $new_order->setPayment($paymentDAO->getPaymentById($_REQUEST["payment_method"]));
    $new_order->setUser($userDAO->getUserById($_SESSION["id"]));

    $new_order = $orderDAO->storeOrder($new_order); // Inserisco nel db

    if($new_order === null || $new_order->getId() === null){ header("Location: error.php"); } // Se non è avvenuto l'inserimento
    

    // Se è andato tutto bene, allora ritorno alla schermata dei dettagli dell'ordine
    $query_string_builder = new QueryStringBuilder("order_details.php");
    $query_string_builder->add("order_id", $new_order->getId());
    header("Location: ". $query_string_builder->build());

}
// Eliminazione di un ordine
else if(isset($_REQUEST["operation"]) && $_REQUEST["operation"] == "delete"){
    
    // Se non è stato fornito l'id dell'ordine
    if(!isset($_REQUEST["order_id"])){
        echo AjaxResponse::genericServerError()->build();
        exit;
    }

    // Effettuo la cancellazione dell'ordine
    if(($result = $orderDAO->deleteOrderById($_REQUEST["order_id"])) == null){
        echo AjaxResponse::genericServerError()->build();
        exit;
    }

    // Se tutto è andato bene
    echo AjaxResponse::okNoContent()->build();
    exit;

}
// Informazioni di un ordine
else if(isset($_REQUEST["operation"]) && $_REQUEST["operation"] == "get-info"){

    // Se non è stato fornito l'id dell'ordine
    if(!isset($_REQUEST["order_id"])){
        echo AjaxResponse::genericServerError()->build();
        exit;
    }


    // Recupero l'ordine
    $order = $orderDAO->getOrderById($_REQUEST["order_id"]);

    // Se l'ordine non è stato trovato
    if($order == null){
        echo AjaxResponse::genericServerError()->build();
        exit;
    }


    // Ritorno tutte le informazioni necessarie
    $ajax_response = new AjaxResponse("OK");

    $ajax_response->add("order_id",$order->getId());
    $ajax_response->add("order_status",$order->getStatus());

    echo $ajax_response->build();
    exit;
    

}

?>