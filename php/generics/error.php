<?php

$error_page = new Template("skin/generics/error.html");


// Testo di errore generico
$title_message = "Titolo generico";
$text_message = "Testo generico";

if(isset($_GET["title_message"])){
    $title_message= base64_decode($_GET["title_message"]);
    $text_message = isset($_GET["text_message"]) ? base64_decode($_GET["text_message"]) : $text_message;  
}

$error_page->setContent("error_title",$title_message);
$error_page->setContent("error_message",$text_message);

?>