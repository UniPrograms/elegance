<?php

require_once("include/model/proxy/NotifyProxy.php");


class NotifyDAO extends DAO{

    private PDOStatement $stmtGetNotifyById;
    private PDOStatement $stmtGetNotifyByUser;
    private PDOStatement $stmtInsertNotify;
    private PDOStatement $stmtUpdateNotify;
    private PDOStatement $stmtDeleteNotify;

    // Costruttore
    public function __construct(?DataLayer $dataLayer) {
        parent::__construct($dataLayer);
        $this->init();
    }


    // Inizializzazione degli statement
    public function init(): void {
        $this->stmtGetNotifyById = $this->conn->prepare("SELECT * FROM NOTIFICA WHERE ID = ?;");
        $this->stmtGetNotifyByUser = $this->conn->prepare("SELECT * FROM NOTIFICA WHERE ID_UTENTE = ? ORDER BY ID DESC;");
        $this->stmtInsertNotify = $this->conn->prepare("INSERT INTO NOTIFICA (OGGETTO, TESTO, ID_UTENTE) VALUES (?,?,?);");
        $this->stmtUpdateNotify = $this->conn->prepare("UPDATE NOTIFICA SET OGGETTO = ?, TESTO = ?, ID_UTENTE = ?, STATO = ?, DATE = ? WHERE ID = ?;");
        $this->stmtDeleteNotify = $this->conn->prepare("DELETE FROM NOTIFICA WHERE ID = ?;");
    }


    // Statemetn

    /**
     * 
     * 
     * 
     * 
     * 
     */
    public function getNotifyById(int $id): ?Notify{
        $this->stmtGetNotifyById->bindValue(1, $id, PDO::PARAM_INT);
        $this->stmtGetNotifyById->execute();

        $rs = $this->stmtGetNotifyById->fetch(PDO::FETCH_ASSOC);

        return $rs ? $this->createNotify($rs) : null;
    }
    /**
     * 
     * 
     * 
     * 
     * 
     */
    public function getNotificationUser(User $user): array {
        $this->stmtGetNotifyByUser->bindValue(1, $user->getId(), PDO::PARAM_INT);
        $this->stmtGetNotifyByUser->execute();
        
        $result = [];
        
        while ($rs = $this->stmtGetNotifyByUser->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $this->createNotify($rs);
        }
        return $result;
    }
    /**
     * 
     * 
     * 
     * 
     * 
     */
    public function getNotificationsByUserId(int $id): array {
        $this->stmtGetNotifyByUser->bindValue(1, $id, PDO::PARAM_INT);
        $this->stmtGetNotifyByUser->execute();
        
        $result = [];
        while ($rs = $this->stmtGetNotifyByUser->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $this->createNotify($rs);
        }
        return $result;
    }
    /**
     * 
     * 
     * 
     * 
     * 
     */
    public function storeNotify(Notify $notify): bool {
        if ($notify->getId() !== null) { // Aggiorno la notifica
            $this->stmtUpdateNotify->bindValue(1, $notify->getObject(), PDO::PARAM_STR);
            $this->stmtUpdateNotify->bindValue(2, $notify->getText(), PDO::PARAM_STR);
            $this->stmtUpdateNotify->bindValue(3, $notify->getUser()->getId(), PDO::PARAM_INT);
            $this->stmtUpdateNotify->bindValue(4, $notify->getState(), PDO::PARAM_STR);
            $this->stmtUpdateNotify->bindValue(5, $notify->getDate(), PDO::PARAM_STR);
            $this->stmtUpdateNotify->bindValue(6, $notify->getId(), PDO::PARAM_INT);
            
            return $this->stmtUpdateNotify->execute();
        } else {   // Inserisco la notifica
            $this->stmtInsertNotify->bindValue(1, $notify->getObject(), PDO::PARAM_STR);
            $this->stmtInsertNotify->bindValue(2, $notify->getText(), PDO::PARAM_STR);
            $this->stmtInsertNotify->bindValue(3, $notify->getUser()->getId(), PDO::PARAM_INT);

            return $this->stmtInsertNotify->execute();
        }
    }
    /**
     * 
     * 
     * 
     * 
     * 
     */
    public function deleteNotify(Notify $notify): bool {
        $this->stmtDeleteNotify->bindValue(1, $notify->getId(), PDO::PARAM_INT);
        return $this->stmtDeleteNotify->execute();
    }



    // Metodi privati

    private function createNotify(array $rs): Notify {
        $notify = new NotifyProxy($this->dataLayer);
        $notify->setId($rs['ID']);
        $notify->setObject($rs['OGGETTO']);
        $notify->setText($rs['TESTO']);
        $notify->setState($rs['STATO']);
        $notify->setUserId($rs['ID_UTENTE']);
        $notify->setDate($rs['DATE']);
        return $notify;
    }



}

?>
