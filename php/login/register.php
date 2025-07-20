<?php

require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");
require_once("include/utility/AuthManager.php");


$factory = new DataLayer(new DB_Connection());
$userDAO =  $factory->getUserDAO();


if (
    isset($_POST["firstname"]) && isset($_POST["lastname"]) &&
    isset($_POST["email"]) && isset($_POST["password"]) &&
    isset($_POST["confirm_password"])
) {


    // Controllo se le l'email è disponibile
    if($userDAO->getUserByEmail($_POST["email"]) != null){
        header("Location: register.php?error=0");
        exit;
    }

    // Controllo se le password sono diverse 
    if ($_POST["password"] != $_POST["confirm_password"]) {
        header("Location: register.php?error=1");
        exit;
    }


    // Mi creo l'entità del nuovo utente e setto i campi
    $user = $userDAO->createEntity();
    $user->setName($_POST["firstname"]);
    $user->setSurname($_POST["lastname"]);
    $user->setEmail($_POST["email"]);
    $user->setPassword(AuthManager::encryptPasswordSHA($_POST["password"]));
    $user->setRole(isset($_POST["role"]) ? $_POST["role"] : "UTENTE");


    // Inserisco il nuovo utente
    $newUser = $userDAO->storeUser($user);

    if($newUser != null){
        $_SESSION["auth"] = true;
        $_SESSION["id"] = $newUser->getId();
        $_SESSION["nome"] = $newUser->getName();
        $_SESSION["cognome"] = $newUser->getSurname();
        $_SESSION["email"] = $newUser->getEmail();        
        $_SESSION["ruolo"] = $newUser->getRole();
        $_SESSION["is_admin"] = strtoupper($user->getRole()) == "AMMINISTRATORE";  

        // Se è un nuovo utente
        if($newUser->getRole() == "UTENTE"){
            header("Location: index.php");
            exit;
        }
        else{
            // Inserisci cosa fare se si è inserito un nuovo utente
        }

    }
}



$register_page = new Template("skin/login/register.html");

if(isset($_GET["error"])){
    switch($_GET["error"]){
        case 0:
            $register_page->setContent("error","The email address is already in use. Please use a different email.");
            break;
        case 1:
            $register_page->setContent("error","Passwords do not match. Please try again.");
            break;
        default:
            $register_page->setContent("error","Generic Error.");
            
    }
}