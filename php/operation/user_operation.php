<?php
// Database
require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");

require_once("include/model/WishlistItem.php");

// Se la sessione non è attiva
if(!isset($_SESSION["auth"])){
    // Reindirizzamento di una pagina di errore o login
}


//DAO 
$factory = new DataLayer(new DB_Connection());
$userDAO = $factory->getUserDAO();



// Aggiornamento di un utente (info personali)
if(isset($_REQUEST["update"]) && $_REQUEST["update"] == "personal-info"){
        
    // Prendo l'utente loggato
    $user = $userDAO->getUserById($_SESSION["id"]);

    // Controllo se sono stati modificati i campi e gli aggiorno
    if(isset($_REQUEST["user_name"]) && !empty($_REQUEST["user_name"])){ $user->setName($_REQUEST["user_name"]);}
    if(isset($_REQUEST["user_surname"]) && !empty($_REQUEST["user_surname"])) { $user->setSurname($_REQUEST["user_surname"]);}
    if(isset($_REQUEST["user_phone"]) && !empty($_REQUEST["user_phone"])){ $user->setPhoneNumber($_REQUEST["user_phone"]);}
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
else if(isset($_REQUEST["update"]) && $_REQUEST["update"] == "change-password"){

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
else if(isset($_REQUEST["delete"])){
    
}


// Altrimenti
else{

}
?>