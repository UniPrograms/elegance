<?php
// Database
require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");
require_once("include/utility/QueryStringBuilder.php");
require_once("include/utility/AjaxResponse.php");
require_once("include/model/Category.php");


//DAO 
$factory = new DataLayer(new DB_Connection());
$categoryDAO = $factory->getCategoryDAO();




// Rimozione di un articolo
if(isset($_REQUEST["operation"]) && $_REQUEST["operation"] == "delete"){


    if(!isset($_SESSION["auth"])){
        echo AjaxResponse::sessionError()->build();
        exit;
    }

    if(!isset($_REQUEST["category_id"])){
        echo AjaxResponse::genericServerError()->build();
        exit;
    }

    // Elimino l'articolo dal db
    $result = $categoryDAO->deleteCategoryById($_REQUEST["category_id"]);

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


    if(!isset($_REQUEST["category_name"])){
        echo AjaxResponse::genericServerError()->build();
        exit;
    }

    // Se qualche dato non è stato inviato
    if(isset($_REQUEST["category_id"])){
        $category = $categoryDAO->getCategoryById($_REQUEST["category_id"]);
    }else{
        $category = new Category();
    }


    // Aggionro i dati/creo la nuova categoria
    $category->setName($_REQUEST["category_name"]);

    // Se qualcosa va storto
    if(($category= $categoryDAO->storeCategory($category)) == null){
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