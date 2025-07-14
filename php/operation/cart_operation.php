<?php
// Database
require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");
require_once("include/utility/QueryStringBuilder.php");
require_once("include/utility/AjaxResponse.php");
require_once("include/model/CartItem.php");

// Se la sessione non è attiva
if(!isset($_SESSION["auth"])){
    // Reindirizzamento di una pagina di errore o login
}


//DAO 
$factory = new DataLayer(new DB_Connection());
$cartItemDAO = $factory->getCartItemDAO();
$cartDAO = $factory->getCartDAO();
$articleDAO = $factory->getArticleDAO();



// Inserimento di un articolo all'interno del carrello
if(isset($_REQUEST["store"])){
        
    // Se non è stato l'id di un articolo
    if(!(isset($_REQUEST["product_id"]) && isset($_REQUEST["size_id"]) && isset($_REQUEST["color_id"]))){
        $ajax_response = new AjaxResponse("ERROR");
        $ajax_response->add("title_message","Errore del server");
        $ajax_response->add("text_message","Il server non ha potuto elaborare la richiesta.");
        echo $ajax_response->build();
        exit;
    }

    // Costruisco il nuovo item
    $new_cart_item = new CartItem();
    $new_cart_item->setArticle($articleDAO->getArticleByProductSizeColor($_REQUEST["product_id"], $_REQUEST["size_id"], $_REQUEST["color_id"] ));
    $new_cart_item->setCart($cartDAO->getCartByUserId($_SESSION["id"]));

    $new_cart_item = $cartItemDAO->storeItem($new_cart_item); // Lo inserisco nel db

    // Se la store è fallita
    if($new_cart_item == null){
        $ajax_response = new AjaxResponse("ERROR");
        $ajax_response->add("title_message","Errore del server");
        $ajax_response->add("text_message","Non è possibile inserire il prodotto.");
        echo $ajax_response->build();
        exit;
    }

    $query_string_builder = new QueryStringBuilder("product.php");
    $query_string_builder->add("product_id", $_REQUEST["product_id"]);
    header("Location: ". $query_string_builder->build());

    /*
    $cart = $cartDAO->getCartByUserId($_SESSION["id"]);
    
    $ajax_response = new AjaxResponse("OK");
    $ajax_response->add("counter", (string)$cart->getSize());
    $ajax_response->add("total_price", (string)$cart->getPrice());
    echo $ajax_response->build();
    exit;
    */
}


// Rimozione di un articolo all'interno del carrello
else if(isset($_REQUEST["delete"])){
    
    // Se non è stato l'id di un articolo
    if(!isset($_REQUEST["cart_item_id"])){
        $ajax_response = new AjaxResponse("ERROR");
        $ajax_response->add("title_message","Errore del server.");
        $ajax_response->add("text_message","Non è stato possibile eliminare il prodotto.");
        echo $ajax_response->build();
        exit;
    }

    // Prendo il prodotto e lo elimino dal db
    $current_cart_item = $cartItemDAO->getCartItemById($_REQUEST["cart_item_id"]);

    // Se è andata a buon fine
    if($result = $cartItemDAO->deleteItem($current_cart_item)){
        $cart = $cartDAO->getCartByUserId($_SESSION["id"]);
        $ajax_response = new AjaxResponse("OK");
        $ajax_response->add("counter", (string)$cart->getSize());
        $ajax_response->add("total_price", (string)$cart->getPrice());
    }
    else{   // Se l'operazione non è andata a buon fine
        $ajax_response = new AjaxResponse("ERROR");
        $ajax_response->add("title_message","Errore del server.");
        $ajax_response->add("text_message","Non è stato possibile eliminare il prodotto.");
    }

    echo $ajax_response->build();
    exit;
}


// Conta il numero di elementi all'interno del carrello
else if(isset($_REQUEST["count"])){

    $cart = $cartDAO->getCartByUserId($_SESSION["id"]);
    
    if($cart == null){
        $ajax_response = new AjaxResponse("ERROR");
        echo $ajax_response->build();
        exit;
    }

    $ajax_response = new AjaxResponse("OK");
    $ajax_response->add("counter", (string)$cart->getSize());
    $ajax_response->add("total_price", (string)$cart->getPrice());
    echo $ajax_response->build();
    exit;
}


// Se non viene inserita una parola per capire 
// l'operazione da effettuare, bisogna decidere
// se rimandare ad una pagina di errore.
// Nel frattempo inserisco una stampa per capire
// Se si entra in questo campo
$ajax_response = new AjaxResponse("ERROR");
$ajax_response->add("title_message","Operazione non valida");
$ajax_response->add("text_message", "Il server non ha potuto elaborare la richiesta.");
echo $ajax_response->build();
exit;

?>