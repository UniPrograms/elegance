<?php
// Database
require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");

require_once("include/model/WishlistItem.php");

// Se la sessione non è attiva
if(!isset($_SESSION["auth"])){
    // Reindirizzamento di una pagina di errore o login
}


//DAO 
$factory = new DataLayer(new DB_Connection());
$wishlistDAO = $factory->getWishlistDAO();
$wishlistItemDAO = $factory->getWishlistItemDAO(); 
$articleDAO = $factory->getArticleDAO();



// Insirisce un articolo all'interno della wishlist
if(isset($_REQUEST["store"])){
    $newItem = new WishlistItem();
    $newItem->setWishlist($wishlistDAO->getWishlistByUserId($_SESSION["id"]));
    $newItem->setArticle($articleDAO->getArticleById($_REQUEST["article_id"]));
    
    $result = $wishlistItemDAO->storeItem($newItem);
}


// Elimina un articolo dalla wishlist
else if(isset($_REQUEST["delete"])){
    $result = $wishlistItemDAO->deleteItemById($_REQUEST["item_id"]);
}


// Sposta un articolo dalla wishlist al carrello
else if(isset($_REQUEST["move"])){
    // Se qualcosa non viene passato per cui non è possibile reperire l'articolo
    if(!isset($_REQUEST["product_id"]) || !isset($_REQUEST["size_id"]) || !isset($_REQUEST["color_id"])){
        $article = $articleDAO->getArticleByProductSizeColor($_REQUEST["product_id"],$_REQUEST["size_id"],$_REQUEST["color_id"]);

        if($article != null){
            $newWishlistItem = new WishlistItem();
            $newWishlistItem->setArticle($article);
            $newWishlistItem->setWishlist($wishlistDAO->getWishlistByUserId($_SESSION["id"]));
            $result = $wishlistItemDAO->storeItem($newWishlistItem);
        }
    }
}


// Altrimenti
else{
    echo "Non succede assolutamente nulla";
    // Rimanda ad una pagina di errore
}







?>