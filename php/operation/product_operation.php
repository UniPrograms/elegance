<?php
// Database
require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");
require_once("include/utility/AjaxResponse.php");
require_once("include/utility/ImagePathManager.php");
require_once("include/model/Product.php");


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
    
    // Salvo prima il prodotto per ottenere l'ID
    if(($product = $productDAO->storeProduct($product)) == null){
        echo AjaxResponse::genericServerError()->build();
        exit;
    }
    
    // Gestione upload immagine
    if(isset($_FILES["product_image"]) && $_FILES["product_image"]["error"] == 0){
        $new_path = "cover/";
        $new_image_name = "cover_img_" . $product->getId() . ".jpg";
        
        $image_path = new ImagePathManager(
            $_FILES["product_image"]["tmp_name"],
            $new_path,
            $new_image_name
        );
        
        $final_path = $image_path->moveUploadedFile();
        
        if($final_path != null){
            // Aggiorna il prodotto con il path dell'immagine
            $product->setCopertina($final_path);
            $productDAO->storeProduct($product);
        }
    }

    $ajax_response = AjaxResponse::okNoContent();
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


echo AjaxResponse::noOperationError()->build();
exit;
?>