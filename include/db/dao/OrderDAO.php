<?php

require_once("include/model/proxy/OrderProxy.php");


class OrderDAO extends DAO {


    

    private PDOStatement $stmtGetOrderById;
    private PDOStatement $stmtGetAllOrders;
    private PDOStatement $stmtGetOrderByUser;
    private PDOStatement $stmtInsertOrder;
    private PDOStatement $stmtUpdateOrder;
    private PDOStatement $stmtDeleteOrder;
    private PDOStatement $stmtGetOrderByIdAndUserId;



    // Costruttore
    public function __construct(?DataLayer $dataLayer) {
        parent::__construct($dataLayer);
        $this->init();
    }


    // Inizializzazione degli statement
    public function init(): void {
        $this->stmtGetOrderById = $this->conn->prepare("SELECT * FROM ORDINE_COMPLETO WHERE ID = ?;");
        $this->stmtGetAllOrders = $this->conn->prepare("SELECT * FROM ORDINE_COMPLETO;");
        $this->stmtGetOrderByUser = $this->conn->prepare("SELECT * FROM ORDINE_COMPLETO WHERE ID_UTENTE = ?;");
        $this->stmtInsertOrder = $this->conn->prepare("INSERT INTO ORDINE (ID_INDIRIZZO, ID_UTENTE, ID_PAGAMENTO, ID_SPEDIZIONE) VALUES (?,?,?,?);");
        $this->stmtUpdateOrder = $this->conn->prepare("UPDATE ORDINE SET DATA_ORDINE = ?, DATA_ARRIVO = ?, PREZZO = ?, INDIRIZZO_CONSEGNA = ?, STATO = ?, ID_UTENTE = ?, ID_PAGAMENTO = ?, ID_SPEDIZIONE = ? WHERE ID = ?;");
        $this->stmtDeleteOrder = $this->conn->prepare("DELETE FROM ORDINE WHERE ID = ?;");
        $this->stmtGetOrderByIdAndUserId = $this->conn->prepare("SELECT * FROM ORDINE_COMPLETO WHERE ID = ? AND ID_UTENTE = ?;");
    }


    // Statemetn

    /**
     * 
     * 
     * 
     * 
     * 
     */
    public function getOrderById(int $id): ?Order{
        $this->stmtGetOrderById->bindValue(1, $id, PDO::PARAM_INT);
        $this->stmtGetOrderById->execute();

        $rs = $this->stmtGetOrderById->fetch(PDO::FETCH_ASSOC);

        return $rs ? $this->createOrder($rs) : null;
    }
    /**
     * 
     * 
     * 
     * 
     * 
     */
    public function getAllOrders(): array {
        $this->stmtGetAllOrders->execute();
        $result = [];

        while ($rs = $this->stmtGetAllOrders->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $this->createOrder($rs);
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
    public function getOrderByUser(User $user): array {
        $this->stmtGetOrderByUser->bindValue(1, $user->getId(), PDO::PARAM_STR);
        $this->stmtGetOrderByUser->execute();
        
        $result = [];
        while ($rs = $this->stmtGetOrderByUser->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $this->createOrder($rs);
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
    public function getOrderByUserId(int $id): array {
        $this->stmtGetOrderByUser->bindValue(1, $id, PDO::PARAM_STR);
        $this->stmtGetOrderByUser->execute();
        
        $result = [];
        while ($rs = $this->stmtGetOrderByUser->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $this->createOrder($rs);
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
    public function getOrderByIdAndUserId(int $id_order, int $id_user): ?Order{
        $this->stmtGetOrderByIdAndUserId->bindValue(1, $id_order, PDO::PARAM_INT);
        $this->stmtGetOrderByIdAndUserId->bindValue(2, $id_user, PDO::PARAM_INT);
        $this->stmtGetOrderByIdAndUserId->execute();

        $rs = $this->stmtGetOrderByIdAndUserId->fetch(PDO::FETCH_ASSOC);

        return $rs ? $this->createOrder($rs) : null;
    }
 /**
     * 
     * 
     * 
     * 
     * 
     */
    public function storeOrder(Order $order): ?Order {
        if ($order->getId() !== null) { 
            $this->stmtUpdateOrder->bindValue(1, $order->getOrderDate(), PDO::PARAM_STR);
            $this->stmtUpdateOrder->bindValue(2, $order->getDeliveryDate(), PDO::PARAM_STR);
            $this->stmtUpdateOrder->bindValue(3, $order->getPrice(), PDO::PARAM_STR);
            $this->stmtUpdateOrder->bindValue(4, $order->getAddress()->getId(), PDO::PARAM_INT);
            $this->stmtUpdateOrder->bindValue(5, $order->getStatus(), PDO::PARAM_STR);
            $this->stmtUpdateOrder->bindValue(6, $order->getUser()->getId(), PDO::PARAM_INT);
            $this->stmtUpdateOrder->bindValue(7, $order->getPayment()->getId(), PDO::PARAM_INT);
            $this->stmtUpdateOrder->bindValue(8, $order->getDelivery()->getId(), PDO::PARAM_INT);
            $this->stmtUpdateOrder->bindValue(9, $order->getId(), PDO::PARAM_INT);
            
            if($this->stmtUpdateOrder->execute()){
                return $order;
            }
        } else { 
            $this->stmtInsertOrder->bindValue(1, $order->getAddress()->getId(), PDO::PARAM_INT);
            $this->stmtInsertOrder->bindValue(2, $order->getUser()->getId(), PDO::PARAM_INT);
            $this->stmtInsertOrder->bindValue(3, $order->getPayment()->getId(), PDO::PARAM_INT);
            $this->stmtInsertOrder->bindValue(4, $order->getDelivery()->getId(), PDO::PARAM_INT);

            if($this->stmtInsertOrder->execute()){
                $order->setId($this->conn->lastInsertId());
                return $order;
            }
        }
        return null;
    }
    /**
     * 
     * 
     * 
     * 
     * 
     */
    public function deleteOrder(Order $Order): bool {
        $this->stmtDeleteOrder->bindValue(1, $Order->getId(), PDO::PARAM_INT);
        return $this->stmtDeleteOrder->execute();
    }



    // Metodi privati

    private function createOrder(array $rs): Order {
        $order = new OrderProxy($this->dataLayer);
        $order->setId($rs['ID']);
        $order->setOrderDate($rs['DATA_ORDINE']);
        $order->setDeliveryDate($rs['DATA_ARRIVO']);
        $order->setPrice($rs['PREZZO_TOTALE']);
        $order->setAddressId($rs['ID_INDIRIZZO']);
        $order->setStatus($rs['STATO']);
        $order->setUserId($rs['ID_UTENTE']);
        $order->setPaymentId($rs['ID_PAGAMENTO']);
        $order->setDeliveryId($rs['ID_SPEDIZIONE']);
        return $order;
    }

}

?>
