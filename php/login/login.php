
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

    if ($user->getPassword() == $password) {
        $_SESSION["auth"] = true;
        $_SESSION["id"] = $row["ID"];
        $_SESSION["nome"] = $row["NOME"];
        $_SESSION["cognome"] = $row["COGNOME"];
        $_SESSION["email"] = $row["EMAIL"];        
        $_SESSION["ruolo"] = $row["RUOLO"];
            
            
        if($row["RUOLO"] == 'USER') { header("Location: index.php"); }
        if($row["RUOLO"] == "ADMIN")  { header("Location: admin_home.php"); }
        
        
        
    }
    // Login non effettuato con successo
    else{
        header("Location: login.php?error=on");
    }
    
    exit;
}

$login_page = new Template("skins/login/login.html");

if(isset($_GET["error"])){
    $login_page->setContent("error","Username/Password errati.");
}
?>