<?php

session_start();

// Rimuovi tutti i dati associati alla sessione
session_unset();

// Distruggi la sessione
session_destroy();

header("Location: index.php");
exit;

?>