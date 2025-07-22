<?php
// Database
require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");
require_once("include/utility/QueryStringBuilder.php");
require_once("include/utility/AjaxResponse.php");
require_once("include/model/Country.php");


//DAO 
$factory = new DataLayer(new DB_Connection());
$countryDAO = $factory->getCountryDAO();



// Rimozione di un paese
if(isset($_REQUEST["operation"]) && $_REQUEST["operation"] == "delete"){


    if(!isset($_SESSION["auth"])){
        echo AjaxResponse::sessionError()->build();
        exit;
    }

    if(!isset($_REQUEST["country_id"])){
        echo AjaxResponse::genericServerError()->build();
        exit;
    }

    // Elimino il paese dal db
    $result = $countryDAO->deleteCountryById($_REQUEST["country_id"]);

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


    if(!isset($_REQUEST["country_name"])){
        echo AjaxResponse::genericServerError()->build();
        exit;
    }

    // Se qualche dato non è stato inviato
    if(isset($_REQUEST["country_id"])){
        $country = $countryDAO->getCountryById($_REQUEST["country_id"]);
    }else{
        $country = new Country();
    }


    // Aggionro i dati/creo la nuova categoria
    $country->setName($_REQUEST["country_name"]);

    // Se qualcosa va storto
    if(($country = $countryDAO->storeCountry($country)) == null){
        echo AjaxResponse::genericServerError()->build();
        exit;
    }

    echo AjaxResponse::okNoContent()->build();
    exit;
}

// Nel caso non venga selezionata nessuna operazione
echo AjaxResponse::noOperationError()->build();
exit;

?>