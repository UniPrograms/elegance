<?php
// Database
require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");
require_once("include/utility/QueryStringBuilder.php");
require_once("include/utility/AjaxResponse.php");
require_once("include/utility/ImagePathManager.php");
require_once("include/model/Image.php");



//DAO 
$factory = new DataLayer(new DB_Connection());
$imageDAO = $factory->getImageDAO();



if(isset($_REQUEST["operation"]) && $_REQUEST['operation'] == 'store' ){
    
    header("Content-Type: application/json");
    
    // Controllo se la sessione è attiva
    if(!isset($_SESSION["auth"])){
        echo AjaxResponse::sessionError()->build();
        exit;
    }

    // 1. Controllo parametri
    if(!(isset($_REQUEST["product_id"]) && isset($_REQUEST["image_url"]) && isset($_FILES['image']) && $_FILES['image']['error'] == 0)){
        echo AjaxResponse::genericServerError()->build();
        exit;
    }

    // 2. Recupero prodotto
    $product = $factory->getProductDAO()->getProductById((int)$_REQUEST["product_id"]);
    if(!$product){
        echo AjaxResponse::genericServerError()->build();
        exit;
    }

    // 3. Inserimento nel DB (path generico, il nome file sarà generato dal DB)
    $image = new Image();
    $image->setPath("img/my_img/product"); // path generico, il DAO genererà il nome file

    // La storeImage deve restituire l'oggetto Image con il path completo
    $newImage = $imageDAO->storeImage($image, $product);
    if(!$newImage){
        echo AjaxResponse::genericServerError()->build();
        exit;
    }

    // 4. Copia fisica del file nella cartella del progetto
    
    $tmpFile = $_FILES['image']['tmp_name'];
    $finalPath = $newImage->getPath();
    $relativeDir = dirname(str_replace("img/my_img/", "", $finalPath));
    $fileName = basename($finalPath);
    $imagePathManager = new ImagePathManager($tmpFile, $relativeDir, $fileName);
    $resultPath = $imagePathManager->moveUploadedFile();
    if(!$resultPath){
        echo AjaxResponse::genericServerError()->build();
        exit;
    }

    echo AjaxResponse::okNoContent()->build();
    exit;

}


else if(isset($_REQUEST["operation"]) && $_REQUEST["operation"] == "delete"){

    header("Content-Type: application/json");
    
    // Controllo se la sessione è attiva
    if(!isset($_SESSION["auth"])){
        echo AjaxResponse::sessionError()->build();
        exit;
    }

    if(!(isset($_REQUEST["image_id"]))){
        echo AjaxResponse::genericServerError()->build();
        exit;
    }


    // Elimino l'immagine dal db
    if(!$result = $imageDAO->deleteImageById((int)$_REQUEST["image_id"])){
        echo AjaxResponse::genericServerError()->build();
        exit;
    }


    // Se tutto è andato bene
    echo AjaxResponse::okNoContent()->build();
    exit;
}

echo AjaxResponse::noOperationError()->build();
exit;

?>