<?php
// DATABASE
require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");

// Utility
require_once("include/utility/QueryStringBuilder.php");


// Se non Ã¨ stato fatto il login
if(!isset($_SESSION['auth'])) {
    header("Location: login.php");
    exit;
}


// DAO 
$factory = new DataLayer(new DB_Connection());
$userDAO = $factory->getUserDAO();
$cartDAO = $factory->getCartDAO();


$checkout_page = new Template("skin/checkout/checkout.html");


// Setto i valori di defult con l'utente loggato
$user = $userDAO->getUserById($_SESSION["id"]);

$checkout_page->setContent("firstname", $user->getName());
$checkout_page->setContent("lastname", $user->getSurname());
$checkout_page->setContent("email_address", $user->getEmail());

$checkout_page->setContent("phone_number", $user->getPhoneNumber() != null ?  $user->getPhoneNumber()  : "");


// Setto i valori per il carrello
$cart = $cartDAO->getCartByUserId($_SESSION["id"]);

$checkout_page->setContent("total_items", $cart->getSize()); 
$checkout_page->setContent("total_price", $cart->getPrice());
?>