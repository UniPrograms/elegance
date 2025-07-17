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
$productDAO = $factory->getProductDAO();


// Inserimento di un prodotto
if(isset($_REQUEST["operation"]) && $_REQUEST["operation"] == "store"){
    echo "store";
    exit;
}


// Eliminazione di un prodotto
else if(isset($_REQUEST["operation"]) && $_REQUEST["operation"] == "delete"){
    
    // Se non è stato passato l'id
    if(!isset($_REQUEST["product_id"])){
        echo AjaxResponse::genericServerError()->build();
        exit;
    }

    // Elimino il prodotto dal db
    $result = $productDAO->deleteProductById($_REQUEST['product_id']);

    // Se qualcosa non ha funzionato
    if(!$result){
        echo AjaxResponse::genericServerError()->build();
        exit;
    }


    // Se è andato tutto bene
    echo AjaxResponse::okNoContent()->build();
    exit;
}


?>