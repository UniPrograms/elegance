
<?php

// Templating
require_once("include/template2.inc.php");

// Database
require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");


// DAO
$factory = new DataLayer(new DB_Connection());
$userDAO = $factory->getUserDAO();

// Se sono stati inviti dei dati per provare ad effettuare il login
if (isset($_POST["email"]) && isset($_POST["password"])) {

    // Autentico l'utente
    $email = $_POST["email"];
    $password = $_POST["password"];

    $user = $userDAO->getUserByEmail($email);

    if ($user != null && (strtolower($user->getPassword()) == strtolower($password))) {
        $_SESSION["auth"] = true;
        $_SESSION["id"] = $user->getId();
        $_SESSION["nome"] = $user->getName();
        $_SESSION["cognome"] = $user->getSurname();
        $_SESSION["email"] = $user->getEmail();        
        $_SESSION["ruolo"] = $user->getRole();
            
            
        if(strtoupper($user->getRole()) == 'UTENTE') { header("Location: index.php"); }
        if(strtoupper($user->getRole()) == "AMMINISTRATORE")  { header("Location: admin_home.php"); }
        
    }
    // Login non effettuato con successo
    else{
        header("Location: login.php?error=on");
    }
    exit;
}

$login_page = new Template("skin/login/login.html");

if(isset($_GET["error"])){
    $login_page->setContent("error","Invalid username or password.");
}
?>