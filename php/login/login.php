
<?php

// Templating
require_once("include/template2.inc.php");

// Database
require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");
require_once("include/utility/QueryStringBuilder.php");


// DAO
$factory = new DataLayer(new DB_Connection());
$userDAO = $factory->getUserDAO();


// Controlla se si è provato a fare il login
if (isset($_POST["email"]) && isset($_POST["password"])) {

   
    $user = $userDAO->getUserByEmail($_POST["email"]);

    // Autentico l'utente
    if ($user != null && (strtolower($user->getPassword()) == strtolower($_POST["password"]))) {
        $_SESSION["auth"] = true;
        $_SESSION["id"] = $user->getId();
        $_SESSION["nome"] = $user->getName();
        $_SESSION["cognome"] = $user->getSurname();
        $_SESSION["email"] = $user->getEmail();        
        $_SESSION["ruolo"] = $user->getRole();
        $_SESSION["is_admin"] = strtoupper($user->getRole()) == "AMMINISTRATORE";   
            
        // Se l'utente è un amministratore, allora lo rimanda alla schermata principale
        if(strtoupper($user->getRole()) == "AMMINISTRATORE")  { 
            header("Location: admin_dashboard.php");
            exit;
        } 

        // Se l'utente è un utente
        header("Location: ". $_REQUEST["reference"]);
        exit;
    }
    
    // Se l'email o la password sono errate e quindi il login è fallito
    header("Location: login.php?error=on");
    exit;
}

// Carica la pagina di login
$login_page = new Template("skin/login/login.html");

// Se non è stata passata nessuna pagina di riferimento, allora riporta alla homepage
$reference = isset($_GET["reference"]) ? base64_decode($_GET["reference"]) : "index.php";
$login_page->setContent("reference_page", $reference);

// Se error è settato, mostra il messaggio di errore
if(isset($_GET["error"])){
    $login_page->setContent("error","Invalid username or password.");
}
?>