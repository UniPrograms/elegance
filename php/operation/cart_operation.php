<?php
// Database
require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");
require_once("include/utility/QueryStringBuilder.php");
require_once("include/utility/AjaxResponse.php");
require_once("include/model/CartItem.php");


//DAO 
$factory = new DataLayer(new DB_Connection());
$cartItemDAO = $factory->getCartItemDAO();
$cartDAO = $factory->getCartDAO();
$articleDAO = $factory->getArticleDAO();


// Inserimento di un articolo all'interno del carrello
if(isset($_REQUEST["operation"]) && $_REQUEST["operation"] == "store"){

    header("ContentType: application/json");


    // Controllo se la sessione è attiva
    if(!isset($_SESSION["auth"])){
        echo AjaxResponse::sessionError()->build();
        exit;
    }


    // Se non è stato l'id di un articolo
    if(!(isset($_REQUEST["product_id"]) && isset($_REQUEST["size_id"]) && isset($_REQUEST["color_id"]))){
        echo AjaxResponse::genericServerError()->build();
        exit;
    }

    // Costruisco il nuovo item
    $new_cart_item = new CartItem();
    $new_cart_item->setArticle($articleDAO->getArticleByProductSizeColor($_REQUEST["product_id"], $_REQUEST["size_id"], $_REQUEST["color_id"] ));
    $new_cart_item->setCart($cartDAO->getCartByUserId($_SESSION["id"]));

    // Eseguo l'inserimento nel db
    $new_cart_item = $cartItemDAO->storeItem($new_cart_item);

    // Se l'operazione è fallita
    if($new_cart_item == null){
        echo AjaxResponse::genericServerError()->build();
        exit;
    }
    
    // Se è andato tutto bene, prendo le informazioni del carrello
    $current_article = $articleDAO->getArticleByProductSizeColor($_REQUEST["product_id"], $_REQUEST["size_id"], $_REQUEST["color_id"] );
    $current_cart = $cartDAO->getCartByUserId($_SESSION["id"]);
    $article_qty = $current_article->getQuantity();
    $cart_qty = $current_cart->getSize();

    // Costruisco la risposta AJAX
    $ajax_response = AjaxResponse::okNoContent();
    $ajax_response->add("cart_item_size",(string) $cart_qty);
    $ajax_response->add("article_qty",(string) $article_qty);
    echo $ajax_response->build();
    exit;

}


// Rimozione di un articolo all'interno del carrello
else if(isset($_REQUEST["operation"]) && $_REQUEST["operation"] == "delete"){


    // Controllo se la sessione è attiva
    if(!isset($_SESSION["auth"])){
        echo AjaxResponse::sessionError()->build();
        exit;
    }

    
    // Se non è stato l'id di un articolo
    if(!isset($_REQUEST["cart_item_id"])){
        echo AjaxResponse::genericServerError()->build();
        exit;
    }

    // Prendo il prodotto e lo elimino dal db
    $current_cart_item = $cartItemDAO->getCartItemById($_REQUEST["cart_item_id"]);

    // Se l'operazione non è andata a buon fine
    if(!($result = $cartItemDAO->deleteItem($current_cart_item))){
        echo AjaxResponse::genericServerError()->build();
        exit;
    }

    // Se è andata a buon fine
    $cart = $cartDAO->getCartByUserId($_SESSION["id"]);

    $ajax_response = AjaxResponse::okNoContent();
    $ajax_response->add("counter", (string)$cart->getSize());
    $ajax_response->add("total_price", (string)$cart->getPrice());
    echo $ajax_response->build();
    exit;
}


// Conta il numero di elementi all'interno del carrello
else if(isset($_REQUEST["operation"]) && $_REQUEST["operation"] == "count"){

    // Controllo se la sessione è attiva
    if(!isset($_SESSION["auth"])){
        echo AjaxResponse::sessionError()->build();
        exit;
    }

    // Prendo il carrello
    $cart = $cartDAO->getCartByUserId($_SESSION["id"]);
    
    // Se il carrello non è stato trovato
    if($cart == null){
        echo AjaxResponse::genericServerError()->build();
        exit;
    }

    // Se è andato tutto bene, prendo le informazioni del carrello
    $ajax_response = AjaxResponse::okNoContent();
    $ajax_response->add("counter", (string)$cart->getSize());
    $ajax_response->add("total_price", (string)$cart->getPrice());
    echo $ajax_response->build();
    exit;
}


echo AjaxResponse::noOperationError()->build();
exit;

?>