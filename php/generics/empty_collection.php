<?php

if(!isset($_SESSION["auth"])){
    header("Location: login.php");
    exit;
}

$empty_collection_page = new Template("skin/generics/empty_collection.html");


// Testo di errore generico
$title_message = "Titolo generico";
$text_message = "Testo generico";

if(isset($_GET["title_message"])){
    $title_message= base64_decode($_GET["title_message"]);
    $text_message = isset($_GET["text_message"]) ? base64_decode($_GET["text_message"]) : $text_message;  
}


$empty_collection_page->setContent("title_message", $title_message);
$empty_collection_page->setContent("text_message", $text_message);


?>