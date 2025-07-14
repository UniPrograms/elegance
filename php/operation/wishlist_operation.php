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
    
    // WishlistItem corrente
    $item = $wishlistItemDAO->getWishlistItemById($_REQUEST["item_id"]);
    
    // Inserisco all'interno del carrello
    $new_cart_item = new CartItem();
    $new_cart_item->setCart($cartDAO->getCartByUserId($_SESSION["id"]));
    $new_cart_item->setArticle($item->getArticle());

    $new_cart_item = $cartItemDAO->storeItem($new_cart_item);
    
    if($new_cart_item != null){
       $result = $wishlistItemDAO->deleteItemById($_REQUEST["item_id"]);
       $ajax_response =  $result ? new AjaxResponse("OK") : new AjaxResponse("NO");
       echo $ajax_response->build();
       exit;
    }
}



// Elimina un articolo dalla wishlist
else if(isset($_REQUEST["delete"])){
    $result = $wishlistItemDAO->deleteItemById($_REQUEST["item_id"]);
    $ajax_response =  $result ? new AjaxResponse("OK") : new AjaxResponse("NO");
    echo $ajax_response->build();
    exit;
}


// Inserisco un articolo nella wishlist
else if(isset($_REQUEST["store"])){
   
}



// Altrimenti
else{
    echo "Non succede assolutamente nulla";
    // Rimanda ad una pagina di errore
}







?>