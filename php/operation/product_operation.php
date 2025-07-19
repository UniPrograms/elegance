<?php
// Database
require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");
require_once("include/utility/AjaxResponse.php");
require_once("include/model/Product.php");

// Se la sessione non è attiva
if(!isset($_SESSION["auth"])){
    // Reindirizzamento di una pagina di errore o login
}


//DAO 
$factory = new DataLayer(new DB_Connection());
$productDAO = $factory->getProductDAO();
$categoryDAO = $factory->getCategoryDAO();
$productorDAO = $factory->getProductorDAO();
$sexDAO = $factory->getSexDAO();



// Inserimento di un prodotto
if(isset($_REQUEST["operation"]) && $_REQUEST["operation"] == "store"){
    
    // Se non sono stati passati tutti i parametri
    if(!(isset($_REQUEST["product_name"])  && isset($_REQUEST["product_price"]) && 
         isset($_REQUEST["product_description"]) && /*isset($_REQUEST["product_cover_img_file"]) && */
         isset($_REQUEST["brand_id"]) && isset($_REQUEST["category_id"]) && isset($_REQUEST["sex_id"]))){
        echo AjaxResponse::genericServerError()->build();
        exit;
    } 


    
    // Se è stato passato l'id del prodotto, allora lo aggiorno
    if(isset($_REQUEST["product_id"])){
        $product = $productDAO->getProductById((int)$_REQUEST["product_id"]);
    }else{
        $product = new Product();
    }

    $product->setName($_REQUEST["product_name"]);
    $product->setPrice($_REQUEST["product_price"]);
    $product->setDescription($_REQUEST["product_description"]);
    $product->setProductor($productorDAO->getProductorById($_REQUEST["brand_id"]));
    $product->setCategory($categoryDAO->getCategoryById($_REQUEST["category_id"]));
    $product->setSex($sexDAO->getSexById($_REQUEST["sex_id"]));
    
    // Se qualcosa non ha funzionato
    if(($product = $productDAO->storeProduct($product)) == null){
        echo AjaxResponse::genericServerError()->build();
        exit;
    }

    $ajax_response = new AjaxResponse("OK");
    $ajax_response->add("product_id", $product->getId());
    echo $ajax_response->build();
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