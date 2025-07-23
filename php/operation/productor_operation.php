<?php
// Database
require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");
require_once("include/utility/QueryStringBuilder.php");
require_once("include/utility/AjaxResponse.php");
require_once("include/utility/ImagePathManager.php");
require_once("include/model/Productor.php");


//DAO 
$factory = new DataLayer(new DB_Connection());
$productorDAO = $factory->getProductorDAO();




// Rimozione di un articolo
if(isset($_REQUEST["operation"]) && $_REQUEST["operation"] == "delete"){


    if(!isset($_SESSION["auth"])){
        echo AjaxResponse::sessionError()->build();
        exit;
    }

    if(!isset($_REQUEST["productor_id"])){
        echo AjaxResponse::genericServerError()->build();
        exit;
    }

    // Elimino l'articolo dal db
    $result = $productorDAO->deleteProductorById($_REQUEST["productor_id"]);

    if(!$result){
        echo AjaxResponse::genericServerError()->build();
        exit;
    }

    echo AjaxResponse::okNoContent()->build();
    exit;
}


else if(isset($_REQUEST["operation"]) && $_REQUEST["operation"] == "store"){


    header("Content-Type: application/json");

    // Controllo se la sessione è attiva
    if(!isset($_SESSION["auth"])){
        echo AjaxResponse::sessionError()->build();
        exit;
    }

    // Controllo se il nome del produttore è stato inviato
    if(!isset($_REQUEST["productor_name"])){
        echo AjaxResponse::genericServerError()->build();
        exit;
    }

    
    // Controllo se l'immagine del produttore è stata inviata
    if(!(isset($_FILES["productor_logo"]) && $_FILES["productor_logo"]["error"] == 0)){
        if(!isset($_REQUEST["productor_id"]) || $_REQUEST["productor_id"] == null){
            echo AjaxResponse::genericServerError()->build();
            exit;
        }
    }

    
    // Controllo se l'id del produttore è stato inviato

    // Se qualche dato non è stato inviato
    if(isset($_REQUEST["productor_id"]) && $_REQUEST["productor_id"] != null){
        $productor = $productorDAO->getProductorById($_REQUEST["productor_id"]);
    }else{
        $productor = new Productor();
    }


    // Aggionro i dati/creo il nuovo produttore
    $productor->setName($_REQUEST["productor_name"]);
    
    // Se ci sono stati errori durante la scrittura
    if(($productor = $productorDAO->storeProductor($productor)) == null){
        echo AjaxResponse::genericServerError()->build();
        exit;
    }


    // Aggiungo l'immagine del produttore
    $new_path = "brand/";
    $new_image_name = "brand_img_" . $productor->getId() . ".jpg";

    // Sposto l'immagine nella cartella brand   
    $image_path = new ImagePathManager(
        $_FILES["productor_logo"]["tmp_name"],
        $new_path,
        $new_image_name
    );
          

    if(($final_path = $image_path->moveUploadedFile()) == null){
        echo AjaxResponse::genericServerError()->build();
        exit;
    }

    $ajax_response = AjaxResponse::okNoContent();
    $ajax_response->add("productor_id", $productor->getId());
    echo $ajax_response->build();
    exit;
}

// Nel caso non venga selezionata nessuna operazione
echo AjaxResponse::noOperationError()->build();
exit;

?>