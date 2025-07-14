<?php
require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");
require_once("include/utility/QueryStringBuilder.php");


// Template
$header_page = new Template("skin/home/header.html");

// DAO
$factory = new DataLayer(new DB_Connection());
$categoryDAO = $factory->getCategoryDAO();
$sexDAO = $factory->getSexDAO();
$cartDAO = $factory->getCartDAO();
$notificationDAO = $factory->getNotifyDAO();

$categories = $categoryDAO->getAllCategories();
$sexes = $sexDAO->getAllSexs();

// Costruisco il menu a tendina
foreach ($sexes as $sex) {

    // Inserisco in tipo di sesso
    $header_page->setContent("sex_name", $sex->getSex());

    // Inserisco tutte le categorie associandole al sesso
    foreach ($categories as $category) {

        // Inserisco il nome della categoria
        $header_page->setContent("category_name", $category->getName());

        // Query String per andare alla pagina dello shop avendo la categoria selezionata e il sesso
        $query_string_builder = new QueryStringBuilder("shop.php");
        $query_string_builder->add("category_id", $category->getId());
        $query_string_builder->add("sex_id", $sex->getId());

        $header_page->setContent("shop_link", $query_string_builder->build());
    }
}


// Inserisco le funzionalità ai button in base a se si è fatto l'accesso o meno
$userIsLogged = isset($_SESSION["auth"]);

if ($userIsLogged) {

    $header_page->setContent("notification_page_link", "notifications_history.php");
    $header_page->setContent("profile_page_link", "profile.php");
    $header_page->setContent("cart_popup_page_link", "cart.php");

    // Numero di articoli all'interno del carrello
    $cart = $cartDAO->getCartByUserId($_SESSION["id"]);
    $header_page->setContent("cart_item_size", $cart->getSize() == 0 ?  "" : $cart->getSize());

    $notifications = $notificationDAO->getNotificationsByUserId($_SESSION["id"], "NON_LETTA");
    
    $header_page->setContent("notification_size", count($notifications) == 0 ? "" : count($notifications) );


} else { // Nel caso fosse stato fatto il login

    $query_string_builder = new QueryStringBuilder("login.php");

    $query_string_builder->addEncoded("reference", "notifications_history.php");
    $header_page->setContent("notification_page_link",  $query_string_builder->build());

    $query_string_builder->cleanParams();
    $query_string_builder->addEncoded("reference", "profile.php");
    $header_page->setContent("profile_page_link", $query_string_builder->build());

    $query_string_builder->cleanParams();
    $query_string_builder->addEncoded("reference", "cart.php");
    $header_page->setContent("cart_popup_page_link",  $query_string_builder->build());
}
