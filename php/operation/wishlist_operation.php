<?php
// Database
require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");
require_once("include/utility/AjaxResponse.php");
require_once("include/model/WishlistItem.php");

// Se la sessione non è attiva
/*
if(!isset($_SESSION["auth"])){
    echo AjaxResponse::genericServerError("Errore di sessione in wishlist_operation.php.")->build();
    exit;
}
*/


//DAO 
$factory = new DataLayer(new DB_Connection());
$wishlistDAO = $factory->getWishlistDAO();
$wishlistItemDAO = $factory->getWishlistItemDAO(); 
$cartDAO = $factory->getCartDAO();
$cartItemDAO = $factory->getCartItemDAO();
$articleDAO = $factory->getArticleDAO();





// Sposto un articolo dalla wishlist al carrello
if(isset($_REQUEST["operation"]) && $_REQUEST['operation'] == 'move'){

    header("Content-Type: application/json;");

    if(!isset($_SESSION["auth"])){
        echo AjaxResponse::genericServerError()->build();
        exit;
    }

    if(!isset($_REQUEST["item_id"])){
        echo AjaxResponse::genericServerError()->build();
        exit;
    }

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
            
            $ajax_response = AjaxResponse::okNoContent();
            $ajax_response->add("cart_item_size", $cart->getSize());
            $ajax_response->add("wishlist_item_size", $wishlist->getSize());

            echo $ajax_response->build();
            exit;
        }

        echo AjaxResponse::genericServerError()->build();
        exit;
    }
}


// Elimina un articolo dalla wishlist
else if(isset($_REQUEST["operation"]) && $_REQUEST['operation'] == 'delete'){
    
    // Controllo se la sessione è attiva
    if(!isset($_SESSION["auth"])){
        echo AjaxResponse::genericServerError()->build();
        exit;
    }


    if(isset($_REQUEST["item_id"])){
        $result = $wishlistItemDAO->deleteItemById($_REQUEST["item_id"]);
    }
    else if(isset($_REQUEST["product_id"]) && isset($_REQUEST["size_id"]) && isset($_REQUEST["color_id"])){
        $article = $articleDAO->getArticleByProductSizeColor($_REQUEST["product_id"], $_REQUEST["size_id"], $_REQUEST["color_id"]);
        $wishlist_item = $wishlistItemDAO->getWishlistItemByArticleId($article->getId(), $wishlistDAO->getWishlistByUserId($_SESSION["id"])->getId());
        $result = $wishlistItemDAO->deleteItemById($wishlist_item->getId());
    }
    else{
        echo AjaxResponse::genericServerError()->build();
        exit;
    }
    
    // Se l'eliminazione NON è andata a buon fine
    if(!$result){
        echo AjaxResponse::genericServerError()->build();
        exit;
    }
    
    // Se l'eliminazione è andata a buon fine
    $wishlist = $wishlistDAO->getWishlistByUserId($_SESSION["id"]);

    $ajax_response = AjaxResponse::okNoContent();
    $ajax_response->add("wishlist_item_size", $wishlist->getSize());
    echo $ajax_response->build();
    exit;
}


// Inserisco un articolo nella wishlist
else if(isset($_REQUEST["operation"]) && $_REQUEST['operation'] == 'store'){

    // Controllo se la sessione è attiva
    if(!isset($_SESSION["auth"])){
        echo AjaxResponse::genericServerError()->build();
        exit;
    }


    // Se non sono stati passati i parametri giusti
    if(!(isset($_REQUEST["product_id"]) && isset($_REQUEST["size_id"]) && isset($_REQUEST["color_id"]))){
        echo AjaxResponse::genericServerError()->build();
        exit;
    }

    // Costruisco il nuovo item
    $new_wishlist_item = new WishlistItem();
    $new_wishlist_item->setArticle($articleDAO->getArticleByProductSizeColor($_REQUEST["product_id"], $_REQUEST["size_id"], $_REQUEST["color_id"] ));
    $new_wishlist_item->setWishlist($wishlistDAO->getWishlistByUserId($_SESSION["id"]));

    // Eseguo la store nel db
    $new_wishlist_item = $wishlistItemDAO->storeItem($new_wishlist_item);

    // Se la store è fallita
    if($new_wishlist_item == null){
        echo AjaxResponse::genericServerError()->build();
        exit;
    }
    
    // Se tutto è andato a buon fine
    echo AjaxResponse::okNoContent()->build();
    exit;
}


// Controlla se un articolo è all'interno della wishlist
else if(isset($_REQUEST["operation"]) && $_REQUEST['operation'] == 'is_present'){



    // Controlla se la sessione è attiva
    if(!isset($_SESSION["auth"])){
        echo AjaxResponse::genericServerError()->build();
        exit;
    }

    // Ricerca wishlist_item tramite l'id
    if(isset($_REQUEST["item_id"])){
        $wishlist_item = $wishlistItemDAO->getWishlistItemById($_REQUEST["item_id"]);
    }
    // Ricerca wishlist item tramite id del prodotto, id della size e id del colore
    else if(isset($_REQUEST["product_id"]) && isset($_REQUEST["size_id"]) && isset($_REQUEST["color_id"])){
        $article = $articleDAO->getArticleByProductSizeColor($_REQUEST["product_id"], $_REQUEST["size_id"], $_REQUEST["color_id"]);
        $wishlist_item = $wishlistItemDAO->getWishlistItemByArticleId($article->getId(), $wishlistDAO->getWishlistByUserId($_SESSION["id"])->getId());
    }
    else{
        echo AjaxResponse::genericServerError()->build();
        exit;
    }

    // Se non è stato trovato nessun item corrispondente
    $ajax_response = AjaxResponse::okNoContent();
    $ajax_response->add("is_present", $wishlist_item == null ? "false" : "true");
    echo $ajax_response->build();
    exit;
}


echo AjaxResponse::noOperationError()->build();
exit;
?>