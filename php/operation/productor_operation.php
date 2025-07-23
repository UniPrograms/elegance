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
        echo AjaxResponse::sessionError("Sessione non attiva")->build();
        exit;
    }

    // Controllo se il nome del produttore è stato inviato
    if(!isset($_REQUEST["productor_name"])){
        echo AjaxResponse::genericServerError("Nome produttore mancante")->build();
        exit;
    }

    $isUpdate = (isset($_REQUEST["productor_id"]) && $_REQUEST["productor_id"] != null && $_REQUEST["productor_id"] !== "");

    // Se è una creazione, l'immagine è obbligatoria
    if(!$isUpdate && !(isset($_FILES["productor_logo"]) && $_FILES["productor_logo"]["error"] == 0)){
        echo AjaxResponse::genericServerError("Immagine produttore obbligatoria per la creazione")->build();
        exit;
    }

    // Recupero o creo il produttore
    if($isUpdate){
        $productor = $productorDAO->getProductorById($_REQUEST["productor_id"]);
        if(!$productor){
            echo AjaxResponse::genericServerError("Produttore non trovato per update")->build();
            exit;
        }
    }else{
        $productor = new Productor();
    }

    // Aggiorno i dati
    $productor->setName($_REQUEST["productor_name"]);

    // Salvo il produttore (così ho l'id)
    if(($productor = $productorDAO->storeProductor($productor)) == null){
        echo AjaxResponse::genericServerError("Errore salvataggio produttore")->build();
        exit;
    }

    // Se è stata inviata una nuova immagine, la processiamo
    if(isset($_FILES["productor_logo"]) && $_FILES["productor_logo"]["error"] == 0){
        $new_path = "brand/";
        $new_image_name = "brand_img_" . $productor->getId() . ".jpg";
        $image_path = new ImagePathManager(
            $_FILES["productor_logo"]["tmp_name"],
            $new_path,
            $new_image_name
        );
        if(($final_path = $image_path->moveUploadedFile()) == null){
            echo AjaxResponse::genericServerError("Errore upload immagine produttore")->build();
            exit;
        }
        // Se vuoi aggiornare il path nel db, decommenta:
        // $productor->setLogo($final_path);
        // $productorDAO->storeProductor($productor);
    } else if(!$isUpdate) {
        // Se sto creando e non ho immagine, errore (già gestito sopra, ma doppio check)
        echo AjaxResponse::genericServerError("Immagine produttore mancante in creazione")->build();
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