<?php
// DATABASE
require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");

// Utility
require_once("include/utility/QueryStringBuilder.php");


// Se non Ã¨ stato fatto il login
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