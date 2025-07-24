<?php

if(!isset($_SESSION["auth"])){
    header("Location: login.php");
    exit;
}


$error_page = new Template("skin/generics/error.html");


// Testo di errore generico
$title_message = "Titolo generico";
$text_message = "Testo generico";

if(isset($_REQUEST["title_message"])){
    $title_message= base64_decode($_REQUEST["title_message"]);
    $text_message = isset($_REQUEST["text_message"]) ? base64_decode($_REQUEST["text_message"]) : $text_message;  
}

$error_page->setContent("error_title",$title_message);
$error_page->setContent("error_message",$text_message);

?>