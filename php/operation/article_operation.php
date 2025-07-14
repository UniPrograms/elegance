<?php
// Database
require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");
require_once("include/utility/QueryStringBuilder.php");
require_once("include/utility/AjaxResponse.php");
require_once("include/model/CartItem.php");

// Se la sessione non è attiva
if(!isset($_SESSION["auth"])){
    // Reindirizzamento di una pagina di errore o login
}


//DAO 
$factory = new DataLayer(new DB_Connection());
$articleDAO = $factory->getArticleDAO();



// Inserimento di un articolo all'interno del carrello
if(isset($_REQUEST["store"])){
    echo "operazione di store";
    exit;
}


// Rimozione di un articolo all'interno del carrello
else if(isset($_REQUEST["delete"])){
    echo "operazione di delete";
    exit;
}


// Conta il numero di elementi all'interno del carrello
else if(isset($_REQUEST["count"])){

    header("Content-type: application/json");

    // Controllo tramite l'id dell'articolo
    if(isset($_REQUEST["article_id"])){
        $article = $articleDAO->getArticleById($_REQUEST["article_id"]);
    }   
    // Controllo tramite i parametri di un articolo
    else if(isset($_REQUEST["product_id"]) && isset($_REQUEST["size_id"]) && isset($_REQUEST["color_id"])){
        $article = $articleDAO->getArticleByProductSizeColor($_REQUEST["product_id"], $_REQUEST["size_id"], $_REQUEST["color_id"]);
    }
    else{
        $ajax_response = new AjaxResponse("ERROR");
        $ajax_response->add("title_error","Il server non ha potuto elaborare la richiesta.");
        echo $ajax_response->build();
    }

    
    $ajax_response = new AjaxResponse("OK");
    $ajax_response->add("qty",$article->getQuantity());
    echo $ajax_response->build();
    exit;
}


// Se non viene inserita una parola per capire 
// l'operazione da effettuare, bisogna decidere
// se rimandare ad una pagina di errore.
// Nel frattempo inserisco una stampa per capire
// Se si entra in questo campo
$ajax_response = new AjaxResponse("ERROR");
$ajax_response->add("title_message","Operazione non valida");
$ajax_response->add("text_message", "Il server non ha potuto elaborare la richiesta.");
echo $ajax_response->build();
exit;

?>