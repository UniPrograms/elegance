<?php
// Database
require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");
require_once("include/utility/AjaxResponse.php");
require_once("include/model/User.php");
require_once("include/utility/ImagePathManager.php");


// Se la sessione non è attiva
if(!isset($_SESSION["auth"])){
    echo AjaxResponse::genericServerError("Errore di sessione in user_operation.php.")->build();
    exit;
}


//DAO 
$factory = new DataLayer(new DB_Connection());
$userDAO = $factory->getUserDAO();



// Aggiornamento di un utente (info personali)
if(isset($_REQUEST["operation"]) && $_REQUEST["operation"] == "personal-info"){

    // Prendo l'utente loggato
    $user = $userDAO->getUserById($_SESSION["id"]);

    // Controllo se sono stati modificati i campi e gli aggiorno
    if(isset($_REQUEST["user_name"]) && !empty($_REQUEST["user_name"])){ $user->setName($_REQUEST["user_name"]);}
    if(isset($_REQUEST["user_surname"]) && !empty($_REQUEST["user_surname"])) { $user->setSurname($_REQUEST["user_surname"]);}
    if(isset($_REQUEST["user_phone"])){ $user->setPhoneNumber($_REQUEST["user_phone"]);}
    // Manca qui il controllo dell'immagine
    
    // Aggiorno l'utente
    $updatedUser = $userDAO->storeUser($user);
    
    // Rimando alla pagina opportuna
    if($updatedUser != null){
        header("Location: personal_info.php");
    }else{
        // Bisogna rimandare ad una pagina di errore o gestire il caso
    }


}



// Aggiornamento utente (password)
else if(isset($_REQUEST["operation"]) && $_REQUEST["operation"] == "change-password"){

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
    if($updatedUser != null){
        header("Location: change_password.php");
    }else{
        // Bisogna rimandare ad una pagina di errore o gestire il caso
    }
}


// Eliminazione di un utente
else if(isset($_REQUEST["operation"]) && $_REQUEST["operation"] == "delete"){
    
    header("Content-Type: application/json;");


    // Se non è stato passato l'id
    if(!isset($_REQUEST["user_id"])){
        echo AjaxResponse::genericServerError("Errore in user_operation.php: delete 1.")->build();
        exit;
    }

    // Eseguo la query
    $result = $userDAO->deleteUserById($_REQUEST["user_id"]);

    // Se non è andata a buon fine
    if(!$result){
        echo AjaxResponse::genericServerError("Errore in user_operation.php: delete 2.")->build();
        exit;
    }


    // Se è andato tutto bene
    $ajax_response = new AjaxResponse("OK");
    echo $ajax_response->build();
    exit;
}


// Ottenimento informazioni utente
else if(isset($_REQUEST['operation']) && $_REQUEST['operation'] == 'user-info'){
    
    header("Content-Type: application/json;");

    // Prendo l'utente loggato
    $user = $userDAO->getUserById($_SESSION["id"]);

    // Se l'utente non esiste
    if($user == null){
        echo AjaxResponse::genericServerError("Errore in user_operation.php: user-info 1.")->build();
        exit;
    }

    // Restituisco le informazioni dell'utente
    $ajax_response = new AjaxResponse("OK");
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
            echo AjaxResponse::genericServerError("Errore in user_operation.php: admin-update 1.")->build();
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
        echo AjaxResponse::genericServerError("Errore in user_operation.php: admin-update 2.")->build();
        exit;
    }


    // Se è andato tutto bene
    echo AjaxResponse::okNoContent()->build();
    exit;
    
}

// Upload dell'immagine utente
else if(isset($_REQUEST['operation']) && $_REQUEST['operation'] == 'upload-image'){
    if(!isset($_REQUEST['image_url'])){
        echo AjaxResponse::genericServerError("Errore in user_operation.php: upload-image 1.")->build();
        exit;
    }

    $user = $userDAO->getUserById($_SESSION["id"]);
    if($user == null){
        echo AjaxResponse::genericServerError("Errore in user_operation.php: upload-image 2.")->build();
        exit;
    }

    $new_path = "user_profile/";
    $new_image_name = "img_" . $user->getId() . ".jpg";

    // Gestione base64
    require_once("include/utility/ImagePathManager.php");
    $image_path = ImagePathManager::fromBase64($_REQUEST["image_url"], $new_path, $new_image_name);
    $final_path = $image_path->moveBase64();

    if($final_path == null){
        echo AjaxResponse::genericServerError("Errore in user_operation.php: upload-image 3.")->build();
        exit;
    }

    $user->setUrlImage($final_path);
    if(($userDAO->storeUser($user)) == null){
        echo AjaxResponse::genericServerError("Errore in user_operation.php: upload-image 4.")->build();
        exit;
    }

    $ajax_response = new AjaxResponse("OK");
    $ajax_response->add("content", "Immagine salvata correttamente!");
    echo $ajax_response->build();
    exit;
}

// Informazioni di un utente
else if(isset($_REQUEST["operation"]) && $_REQUEST["operation"] == "get-info"){

    // Se non è stato fornito l'id dell'utente
    if(!isset($_REQUEST["user_id"])){
        echo AjaxResponse::genericServerError("Errore in user_operation.php: get-info 1.")->build();
        exit;
    }


    // Recupero l'utente
    $user = $userDAO->getUserById($_REQUEST["user_id"]);

    // Se l'utente' non è stato trovato
    if($user == null){
        echo AjaxResponse::genericServerError("Errore in user_operation.php: get-info 2.")->build();
        exit;
    }


    // Ritorno tutte le informazioni necessarie
    $ajax_response = new AjaxResponse("OK");

    $ajax_response->add("user_id",$user->getId());
    $ajax_response->add("user_name",$user->getName());
    $ajax_response->add("user_surname", $user->getSurname());
    $ajax_response->add("user_role",$user->getRole());

    echo $ajax_response->build();
    exit;
    

}


echo AjaxResponse::genericServerError("Nessuna operazione selezionata in user_operation.php.")->build();
exit;
?>