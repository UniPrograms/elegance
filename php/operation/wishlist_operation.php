<?php
// Database
require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");
require_once("include/utility/AjaxResponse.php");
require_once("include/model/WishlistItem.php");

// Se la sessione non è attiva
if(!isset($_SESSION["auth"])){
    // Reindirizzamento di una pagina di errore o login
}


//DAO 
$factory = new DataLayer(new DB_Connection());
$wishlistDAO = $factory->getWishlistDAO();
$wishlistItemDAO = $factory->getWishlistItemDAO(); 
$cartDAO = $factory->getCartDAO();
$cartItemDAO = $factory->getCartItemDAO();
$articleDAO = $factory->getArticleDAO();



// Sposto un articolo dalla wishlist al carrello
if(isset($_REQUEST["move"])){

    header("Content-Type: application/json;");
    // WishlistItem corrente
    $item = $wishlistItemDAO->getWishlistItemById($_REQUEST["item_id"]);
    
    // Inserisco all'interno del carrello
    $new_cart_item = new CartItem();
    $new_cart_item->setCart($cartDAO->getCartByUserId($_SESSION["id"]));
    $new_cart_item->setArticle($item->getArticle());

    $new_cart_item = $cartItemDAO->storeItem($new_cart_item);
    
    if($new_cart_item != null){
        //Elimina l'articolo dalla wishlist
        $result = $wishlistItemDAO->deleteItemById($_REQUEST["item_id"]);

        if($result){
            $cart = $cartDAO->getCartByUserId($_SESSION["id"]);
            $wishlist = $wishlistDAO->getWishlistByUserId($_SESSION["id"]);
            
            $ajax_response = new AjaxResponse("OK");
            $ajax_response->add("cart_item_size", $cart->getSize());
            $ajax_response->add("wishlist_item_size", $wishlist->getSize());

            echo $ajax_response->build();
            exit;
        }
        $ajax_response = new AjaxResponse("ERROR");
        $ajax_response->add("text_message", "Non è stato possibile eseguire l'operazione!");
        echo $ajax_response->build();
        exit;
    }
}



// Elimina un articolo dalla wishlist
else if(isset($_REQUEST["delete"])){
    $result = $wishlistItemDAO->deleteItemById($_REQUEST["item_id"]);
    
    if($result){
        $wishlist = $wishlistDAO->getWishlistByUserId($_SESSION["id"]);

        $ajax_response = new AjaxResponse("OK");
        $ajax_response->add("wishlist_item_size", $wishlist->getSize());
        echo $ajax_response->build();
        exit;
    }

    $ajax_response = new AjaxResponse("ERROR");
    echo $ajax_response->build();
    exit;
}


// Inserisco un articolo nella wishlist
else if(isset($_REQUEST["store"])){
        
    // Se non è stato l'id di un articolo
    if(!(isset($_REQUEST["product_id"]) && isset($_REQUEST["size_id"]) && isset($_REQUEST["color_id"]))){
        $ajax_response = new AjaxResponse("ERROR");
        $ajax_response->add("title_message","Errore del server");
        $ajax_response->add("text_message","Il server non ha potuto elaborare la richiesta.");
        echo $ajax_response->build();
        exit;
    }

    // Costruisco il nuovo item
    $new_wishlist_item = new WishlistItem();
    $new_wishlist_item->setArticle($articleDAO->getArticleByProductSizeColor($_REQUEST["product_id"], $_REQUEST["size_id"], $_REQUEST["color_id"] ));
    $new_wishlist_item->setWishlist($wishlistDAO->getWishlistByUserId($_SESSION["id"]));

    $new_wishlist_item = $wishlistItemDAO->storeItem($new_wishlist_item); // Lo inserisco nel db

    // Se la store è fallita
    if($new_wishlist_item == null){
        $ajax_response = new AjaxResponse("ERROR");
        $ajax_response->add("title_message","Errore del server");
        $ajax_response->add("text_message","Non è possibile inserire il prodotto.");
        echo $ajax_response->build();
        exit;
    }
    
    $ajax_response = new AjaxResponse("OK");

    echo $ajax_response->build();
    exit;

}

?>