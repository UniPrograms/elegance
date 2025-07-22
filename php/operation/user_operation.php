<?php
// Database
require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");
require_once("include/utility/AjaxResponse.php");
require_once("include/model/User.php");
require_once("include/utility/ImagePathManager.php");



//DAO 
$factory = new DataLayer(new DB_Connection());
$userDAO = $factory->getUserDAO();



// Aggiornamento di un utente (info personali)
if(isset($_REQUEST["operation"]) && $_REQUEST["operation"] == "personal-info"){

    // Controllo se la sessione è attiva
    if(!isset($_SESSION["auth"])){
        header("Location: error.php");
        exit;
    }


    // Prendo l'utente loggato
    $user = $userDAO->getUserById($_SESSION["id"]);

    // Controllo se sono stati modificati i campi e gli aggiorno
    if(isset($_REQUEST["user_name"]) && !empty($_REQUEST["user_name"])){ $user->setName($_REQUEST["user_name"]);}
    if(isset($_REQUEST["user_surname"]) && !empty($_REQUEST["user_surname"])) { $user->setSurname($_REQUEST["user_surname"]);}
    if(isset($_REQUEST["user_phone"])){ $user->setPhoneNumber($_REQUEST["user_phone"]);}
     

    // Aggiorno l'utente
    $updatedUser = $userDAO->storeUser($user);
    
    // Rimando alla pagina opportuna
    if($updatedUser == null){
        header("Location: error.php");
        exit;
    }
    header("Location: personal_info.php");
    exit;
}



// Aggiornamento utente (password)
else if(isset($_REQUEST["operation"]) && $_REQUEST["operation"] == "change-password"){

    // Controllo se la sessione è attiva
    if(!isset($_SESSION["auth"])){
        header("Location: error.php");
        exit; 
    }


    // Prendo l'utente loggato
    $user = $userDAO->getUserById($_SESSION["id"]);

    // Controllo se la password corrente è stata inserita correttamente
    if((isset($_REQUEST["current_password"]) && !empty($_REQUEST["current_password"])) && (strtolower($_REQUEST["current_password"]) == strtolower($user->getPassword()))){
        // Controllo se la nuova password e la sua conferma sono state inserite
        if((isset($_REQUEST["new_password"]) && !empty($_REQUEST["new_password"])) && (isset($_REQUEST["confirm_password"]) && !empty($_REQUEST["confirm_password"]))) {
            // Controllo se la nuova password e la sua conferma sono uguali
            if(strtolower($_REQUEST["new_password"]) == strtolower($_REQUEST["confirm_password"])){
                $user->setPassword($_REQUEST["new_password"]);

            }
        }
    }

    // Aggiorno l'utente
    $updatedUser = $userDAO->storeUser($user);

    // Rimando alla pagina opportuna
    if($updatedUser == null){
        header("Location: error.php");
        exit;    
    }
    
    header("Location: change_password.php");
}


// Eliminazione di un utente
else if(isset($_REQUEST["operation"]) && $_REQUEST["operation"] == "delete"){
    
    header("Content-Type: application/json;");


    // Se non è stato passato l'id
    if(!isset($_REQUEST["user_id"])){
        echo AjaxResponse::genericServerError()->build();
        exit;
    }

    // Eseguo la query
    $result = $userDAO->deleteUserById($_REQUEST["user_id"]);

    // Se non è andata a buon fine
    if(!$result){
        echo AjaxResponse::genericServerError()->build();
        exit;
    }


    // Se è andato tutto bene
    echo AjaxResponse::okNoContent()->build();
    exit;
}


// Ottenimento informazioni utente
else if(isset($_REQUEST['operation']) && $_REQUEST['operation'] == 'user-info'){
    
    header("Content-Type: application/json;");

    // Controllo se la sessione è attiva
    if(!isset($_SESSION["auth"])){
        echo AjaxResponse::sessionError()->build();
        exit;
    }


    // Prendo l'utente loggato
    $user = $userDAO->getUserById($_SESSION["id"]);

    // Se l'utente non esiste
    if($user == null){
        echo AjaxResponse::genericServerError()->build();
        exit;
    }

    // Restituisco le informazioni dell'utente
    $ajax_response = AjaxResponse::okNoContent();
    $ajax_response->add("user_role", $user->getRole());
    $ajax_response->add("user_name", $user->getName());
    $ajax_response->add("user_surname", $user->getSurname());
    $ajax_response->add("user_email", $user->getEmail());
    echo $ajax_response->build();
    exit;
}


// Aggiornamento di un utente da parte dell'amministratore
else if(isset($_REQUEST['operation']) && $_REQUEST['operation'] == 'admin-update'){
    

    if(!(isset($_REQUEST["user_id"]) && isset($_REQUEST["user_name"]) && isset($_REQUEST["user_surname"]) && 
         isset($_REQUEST["user_role"]) && isset($_REQUEST["user_phone_number"]))){
            echo AjaxResponse::genericServerError()->build();
            exit;
    }

    // Costruisco l'utente
    $user = $userDAO->getUserById($_REQUEST["user_id"]);

    $user->setName($_REQUEST["user_name"]);
    $user->setSurname($_REQUEST["user_surname"]);
    $user->setRole($_REQUEST["user_role"]);
    $user->setPhoneNumber($_REQUEST["user_phone_number"]);

    // Eseguo l'operazione sul db
    $user = $userDAO->storeUser($user);

    // Se qualcosa è andato storto
    if($user == null){
        echo AjaxResponse::genericServerError()->build();
        exit;
    }


    // Se è andato tutto bene
    echo AjaxResponse::okNoContent()->build();
    exit;
    
}


// Upload dell'immagine utente
else if(isset($_REQUEST['operation']) && $_REQUEST['operation'] == 'upload-image'){
    
    // Controllo se la sessione è attiva
    if(!isset($_SESSION["auth"])){
        echo AjaxResponse::sessionError()->build();
        exit;
    }

    // Controllo se è stato fornito l'url dell'immagine
    if(!isset($_REQUEST['image_url'])){
        echo AjaxResponse::genericServerError()->build();
        exit;
    }

    // Prendo l'utente loggato
    $user = $userDAO->getUserById($_SESSION["id"]);
    if($user == null){
        echo AjaxResponse::genericServerError()->build();
        exit;
    }

    $new_path = "user_profile/";
    $new_image_name = "img_" . $user->getId() . ".jpg";

    // Gestione base64
    $image_path = ImagePathManager::fromBase64($_REQUEST["image_url"], $new_path, $new_image_name);
    $final_path = $image_path->moveBase64();

    if($final_path == null){
        echo AjaxResponse::genericServerError()->build();
        exit;
    }

    $user->setUrlImage($final_path);
    if(($userDAO->storeUser($user)) == null){
        echo AjaxResponse::genericServerError()->build();
        exit;
    }


    echo AjaxResponse::okNoContent()->build();
    exit;
}


// Informazioni di un utente
else if(isset($_REQUEST["operation"]) && $_REQUEST["operation"] == "get-info"){

    // Se non è stato fornito l'id dell'utente
    if(!isset($_REQUEST["user_id"])){
        echo AjaxResponse::genericServerError()->build();
        exit;
    }


    // Recupero l'utente
    $user = $userDAO->getUserById($_REQUEST["user_id"]);

    // Se l'utente' non è stato trovato
    if($user == null){
        echo AjaxResponse::genericServerError()->build();
        exit;
    }


    // Ritorno tutte le informazioni necessarie
    $ajax_response = AjaxResponse::okNoContent("OK");

    $ajax_response->add("user_id",$user->getId());
    $ajax_response->add("user_name",$user->getName());
    $ajax_response->add("user_surname", $user->getSurname());
    $ajax_response->add("user_role",$user->getRole());

    echo $ajax_response->build();
    exit;
    

}


// Aggiornamento del proprio account amministratore 
else if(isset($_REQUEST['operation']) && $_REQUEST['operation'] == 'admin-update-self'){
    
    if(!isset($_SESSION["auth"])){
        echo AjaxResponse::sessionError()->build();
        exit;
    }


    if(!(isset($_REQUEST["user_name"]) && isset($_REQUEST["user_surname"]) && isset($_REQUEST["user_phone_number"]))){
            echo AjaxResponse::genericServerError()->build();
            exit;
    }

    // Costruisco l'utente
    $user = $userDAO->getUserById($_SESSION["id"]);

    $user->setName($_REQUEST["user_name"]);
    $user->setSurname($_REQUEST["user_surname"]);
    $user->setPhoneNumber($_REQUEST["user_phone_number"]);

    // Eseguo l'operazione sul db
    $user = $userDAO->storeUser($user);

    // Se qualcosa è andato storto
    if($user == null){
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