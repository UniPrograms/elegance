<?php
// Database
require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");
require_once("include/utility/QueryStringBuilder.php");
require_once("include/utility/AjaxResponse.php");
require_once("include/model/Article.php");

// Se la sessione non è attiva
if(!isset($_SESSION["auth"])){
    echo AjaxResponse::genericServerError("Errore di sessione in image_operation.php.")->build();
    exit;
}


//DAO 
$factory = new DataLayer(new DB_Connection());
$imageDAO = $factory->getImageDAO();



if(isset($_REQUEST["operation"]) && $_REQUEST['operation'] == 'store' ){

    // Controllo che siano stati inviati tutti i parametri necessari
    if(!(isset($_REQUEST["product_id"]) && isset($_REQUEST["image_url"]))){
        echo AjaxResponse::genericServerError("Errore in image_operation.php: store 1.")->build();
        exit;
    }


    echo AjaxResponse::okNoContent()->build();
    exit;


}




echo AjaxResponse::genericServerError("Nessuna operazione selezionata image_operation.php.")->build();
exit;

?>