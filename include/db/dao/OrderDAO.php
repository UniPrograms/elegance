<?php

require_once("include/model/proxy/OrderProxy.php");


class OrderDAO extends DAO {


    

    private PDOStatement $stmtGetOrderById;
    private PDOStatement $stmtGetAllOrders;
    private PDOStatement $stmtGetOrderByUser;
    private PDOStatement $stmtGetAllOrdersByGenericString;
    private PDOStatement $stmtInsertOrder;
    private PDOStatement $stmtUpdateOrder;
    private PDOStatement $stmtDeleteOrder;
    private PDOStatement $stmtGetOrderByIdAndUserId;
    private PDOStatement $stmtGetAllOrdersCount;
    private PDOStatement $stmtGetAllOrdersCountByStatus;
    private PDOStatement $stmtGetOrderRevanueFromMonthAndYear;

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
        $this->stmtGetAllOrdersByGenericString = $this->conn->prepare("SELECT * FROM ORDINE_COMPLETO WHERE NOME_DESTINATARIO LIKE ? OR COGNOME_DESTINATARIO LIKE ? OR 
                                                                                                            NAZIONE LIKE ? OR CITTA LIKE ? OR VIA LIKE ? OR
                                                                                                            PROVINCIA LIKE ? OR EMAIL LIKE ?;");
        $this->stmtInsertOrder = $this->conn->prepare("INSERT INTO ORDINE (ID_INDIRIZZO, ID_UTENTE, ID_PAGAMENTO) VALUES (?,?,?);");
        $this->stmtUpdateOrder = $this->conn->prepare("UPDATE ORDINE SET DATA_ORDINE = ?, DATA_ARRIVO = ?, ID_INDIRIZZO = ?, STATO = ?, ID_UTENTE = ?, ID_PAGAMENTO = ? WHERE ID = ?;");
        $this->stmtDeleteOrder = $this->conn->prepare("DELETE FROM ORDINE WHERE ID = ?;");
        $this->stmtGetOrderByIdAndUserId = $this->conn->prepare("SELECT * FROM ORDINE_COMPLETO WHERE ID = ? AND ID_UTENTE = ?;");
        $this->stmtGetAllOrdersCount = $this->conn->prepare("SELECT COUNT(*) AS COUNTER FROM ORDINE_COMPLETO; ");
        $this->stmtGetAllOrdersCountByStatus = $this->conn->prepare("SELECT COUNT(*) AS COUNTER FROM ORDINE_COMPLETO WHERE STATO = ?;");
        $this->stmtGetOrderRevanueFromMonthAndYear = $this->conn->prepare("SELECT COALESCE(SUM(PREZZO_TOTALE), 0) AS TOTAL FROM ORDINE_COMPLETO WHERE MONTH(DATA_ORDINE) = ? AND YEAR(DATA_ORDINE) = ?;");
    
    }


    // STATEMENT

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
     public function getOrderRevanueFromMonthAndYear(?int $month, ?int $year): float {
        $this->stmtGetOrderRevanueFromMonthAndYear->bindValue(1, $month, PDO::PARAM_INT);
        $this->stmtGetOrderRevanueFromMonthAndYear->bindValue(2, $year, PDO::PARAM_INT);
        $this->stmtGetOrderRevanueFromMonthAndYear->execute();
        
        $rs = $this->stmtGetOrderRevanueFromMonthAndYear->fetch(PDO::FETCH_ASSOC);
        
        return $rs["TOTAL"];
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
    public function getAllOrdersByGenericString(string $string): array{
        $this->stmtGetAllOrdersByGenericString->bindValue(1, '%'.$string.'%', PDO::PARAM_STR);
        $this->stmtGetAllOrdersByGenericString->bindValue(2, '%'.$string.'%', PDO::PARAM_STR);
        $this->stmtGetAllOrdersByGenericString->bindValue(3, '%'.$string.'%', PDO::PARAM_STR);
        $this->stmtGetAllOrdersByGenericString->bindValue(4, '%'.$string.'%', PDO::PARAM_STR);
        $this->stmtGetAllOrdersByGenericString->bindValue(5, '%'.$string.'%', PDO::PARAM_STR);
        $this->stmtGetAllOrdersByGenericString->bindValue(6, '%'.$string.'%', PDO::PARAM_STR);
        $this->stmtGetAllOrdersByGenericString->bindValue(7, '%'.$string.'%', PDO::PARAM_STR);
        $this->stmtGetAllOrdersByGenericString->execute();

        $result = [];
        while ($rs = $this->stmtGetAllOrdersByGenericString->fetch(PDO::FETCH_ASSOC)) {
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
    public function getAllOrdersByGenericStrings(array $strings): array{
        $result = [];
        foreach($strings as $string){
            foreach($this->getAllOrdersByGenericString($string) as $order){
                $result[$order->getId()] = $order;
            }
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
    public function getAllOrdersCount(?string $status = null): ?int{
        if($status == null){
            $stmt = $this->stmtGetAllOrdersCount;
        }else{
            $stmt = $this->stmtGetAllOrdersCountByStatus;
            $stmt->bindValue(1, strtoupper($status), PDO::PARAM_STR);
        }

        $stmt->execute();
        $rs = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $rs["COUNTER"];
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
            $this->stmtUpdateOrder->bindValue(3, $order->getAddress()->getId(), PDO::PARAM_INT);
            $this->stmtUpdateOrder->bindValue(4, $order->getStatus(), PDO::PARAM_STR);
            $this->stmtUpdateOrder->bindValue(5, $order->getUser()->getId(), PDO::PARAM_INT);
            $this->stmtUpdateOrder->bindValue(6, $order->getPayment()->getId(), PDO::PARAM_INT);
            $this->stmtUpdateOrder->bindValue(7, $order->getId(), PDO::PARAM_INT);
            
            if($this->stmtUpdateOrder->execute()){
                return $order;
            }
        } else { 
            $this->stmtInsertOrder->bindValue(1, $order->getAddress()->getId(), PDO::PARAM_INT);
            $this->stmtInsertOrder->bindValue(2, $order->getUser()->getId(), PDO::PARAM_INT);
            $this->stmtInsertOrder->bindValue(3, $order->getPayment()->getId(), PDO::PARAM_INT);

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
    /**
     * 
     * 
     * 
     * 
     * 
     */
    public function deleteOrderById(int $id): bool {
        $this->stmtDeleteOrder->bindValue(1, $id, PDO::PARAM_INT);
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
        return $order;
    }

}

?>
