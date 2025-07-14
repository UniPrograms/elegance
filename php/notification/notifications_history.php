<?php
// DATABASE
require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");

// Utility
require_once("include/utility/QueryStringBuilder.php");


// Se non è stato fatto il login
if(!isset($_SESSION['auth'])) {
    header("Location: login.php");
    exit;
}


// DAO 
$factory = new DataLayer(new DB_Connection());
$userDAO = $factory->getUserDAO();
$notificationDAO = $factory->getNotifyDAO();

// Template
$notification_history_page = new Template("skin/notification/notifications_history.html");

$notifications = $notificationDAO->getNotificationsByUserId($_SESSION["id"]);

if(count($notifications) == 0){
    $query_string_builder = new QueryStringBuilder("empty_collection.php");
    $query_string_builder->addEncoded("title_message", "Nessuna notifica.");
    $query_string_builder->addEncoded("text_message", "Non hai ancora ricevuto/a nessuna notifica!");
    header("Location: " . $query_string_builder->build());
    exit;
}


foreach($notifications as $notification){

    // Dati della notifica
    $notification_history_page->setContent("notification_object",$notification->getObject());
    $notification_history_page->setContent("notification_date",$notification->getDate());
    $notification_history_page->setContent("notification_text", $notification->getText());


    // Campo per segnalare se la notifica è stata vista o non è stata vista
    $notification_history_page->setContent("notification_read_value", strtoupper($notification->getState()) == 'NON_LETTA' ? "unread" : "read");

    // Non appena questa pagina viene caricata,
    // tutte le notifiche presenti vengono 
    // considerate come viste, quindi aggiorno
    // il loro stato
    $notification->setState("LETTA");
    $notificationDAO->storeNotify($notification);
}
?>