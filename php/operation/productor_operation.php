<?php
// Database
require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");
require_once("include/utility/QueryStringBuilder.php");
require_once("include/utility/AjaxResponse.php");
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


    if(!isset($_SESSION["auth"])){
        echo AjaxResponse::sessionError()->build();
        exit;
    }


    if(!isset($_REQUEST["productor_name"]) || !isset($_REQUEST["productor_logo"])){
        echo AjaxResponse::genericServerError()->build();
        exit;
    }


    // Se qualche dato non è stato inviato
    if(isset($_REQUEST["productor_id"])){
        $productor = $productorDAO->getProductorById($_REQUEST["productor_id"]);
    }else{
        $productor = new Productor();
    }


    // Aggionro i dati/creo la nuova categoria
    $productor->setName($_REQUEST["productor_name"]);
  

   
    // Bisogna aggiungere tutta la logica per gestire l'upload dell'immagine.

    echo AjaxResponse::okNoContent()->build();
    exit;
}

// Nel caso non venga selezionata nessuna operazione
echo AjaxResponse::noOperationError()->build();
exit;

?>