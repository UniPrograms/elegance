<?php
// Database
require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");
require_once("include/utility/QueryStringBuilder.php");
require_once("include/utility/AjaxResponse.php");
require_once("include/model/CartItem.php");

// Se la sessione non è attiva
if(!isset($_SESSION["auth"])){
    echo AjaxResponse::genericServerError()->build();
    exit;
}


//DAO 
$factory = new DataLayer(new DB_Connection());
$articleDAO = $factory->getArticleDAO();


// Conta il numero di elementi all'interno del carrello
if(isset($_REQUEST["operation"]) && $_REQUEST["operation"] == "count"){

    header("ContentType: application/json");

    // Controllo tramite l'id dell'articolo
    if(isset($_REQUEST["article_id"])){
        $article = $articleDAO->getArticleById($_REQUEST["article_id"]);
    }   
    // Controllo tramite i parametri di un articolo
    else if(isset($_REQUEST["product_id"]) && isset($_REQUEST["size_id"]) && isset($_REQUEST["color_id"])){
        $article = $articleDAO->getArticleByProductSizeColor($_REQUEST["product_id"], $_REQUEST["size_id"], $_REQUEST["color_id"]);
    }
    else{
        echo AjaxResponse::genericServerError()->build();
        exit;
    }

    // Se tutto è andato a buon fine
    $ajax_response = new AjaxResponse("OK");
    $ajax_response->add("article_qty",$article->getQuantity());
    echo $ajax_response->build();
    exit;
}

// Ritorna le informazioni necessarie dell'articolo
else if(isset($_REQUEST["operation"]) && $_REQUEST["operation"] == "get_information"){

    header("ContentType: application/json");

    // Se non è stato passato l'id dell'articolo
    if(!isset($_REQUEST["article_id"])){
        echo AjaxResponse::genericServerError()->build();
        exit;
    }

    $article = $articleDAO->getArticleById($_REQUEST["article_id"]);

    // Se non è stato trovato l'articolo (id sbagliato)
    if($article == null){
        echo AjaxResponse::genericServerError()->build();
        exit;
    }

    // Se è andato tutto bene
    $ajax_response = new AjaxResponse("OK");
    $ajax_response->add("size_id",$article->getSize()->getId());
    $ajax_response->add("color_id", $article->getColor()->getId());
    echo $ajax_response->build();
    exit;
}

// Rimozione di un articolo
else if(isset($_REQUEST["operation"]) && $_REQUEST["operation"] == "delete"){

    if(!isset($_REQUEST["article_id"])){
        echo AjaxResponse::genericServerError()->build();
        exit;
    }

    // Elimino l'articolo dal db
    $result = $articleDAO->deleteArticleById($_REQUEST["article_id"]);

    if(!$result){
        echo AjaxResponse::genericServerError()->build();
        exit;
    }

    echo AjaxResponse::okNoContent()->build();
    exit;
}


// Nel caso non venga selezionata nessuna operazione
echo AjaxResponse::genericServerError()->build();
exit;

?>