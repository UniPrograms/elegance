<?php

require_once("include/model/proxy/OrderItemProxy.php");


class OrderItemDAO extends DAO{

    private PDOStatement $stmtGetOrderItemById;
    private PDOStatement $stmtGetAllOrderItems;
    private PDOStatement $stmtGetOrderItemByOrder;



    // Costruttore
    public function __construct(?DataLayer $dataLayer) {
        parent::__construct($dataLayer);
        $this->init();
    }


    // Inizializzazione degli statement
    public function init(): void {
        $this->stmtGetOrderItemById = $this->conn->prepare("SELECT * FROM ORDINE_ARTICOLO WHERE ID = ?;");
        $this->stmtGetAllOrderItems = $this->conn->prepare("SELECT * FROM ORDINE_ARTICOLO;");
        $this->stmtGetOrderItemByOrder = $this->conn->prepare("SELECT * FROM ORDINE_ARTICOLO WHERE ID_ORDINE = ?;");
    }


    // Statemetn

    /**
     * 
     * 
     * 
     * 
     * 
     */
    public function getOrderItemById(int $id){
        $this->stmtGetOrderItemById->bindValue(1, $id, PDO::PARAM_INT);
        $this->stmtGetOrderItemById->execute();

        $rs = $this->stmtGetOrderItemById->fetch(PDO::FETCH_ASSOC);

        return $rs ? $this->createOrderItem($rs) : null;
    }
    /**
     * 
     * 
     * 
     * 
     * 
     */
    public function getAllOrderItems(): array {
        $this->stmtGetAllOrderItems->execute();
        $result = [];

        while ($rs = $this->stmtGetAllOrderItems->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $this->createOrderItem($rs);
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
    public function getOrderItemByOrder(Order $order): array{
        $this->stmtGetOrderItemByOrder->bindValue(1, $order->getId(), PDO::PARAM_INT);
        $this->stmtGetOrderItemByOrder->execute();

        $result = [];
        while ($rs = $this->stmtGetOrderItemByOrder->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $this->createOrderItem($rs);
        }
        return $result;
    }


    // Metodi privati

    private function createOrderItem(array $rs): OrderItem {
        $orderItem = new OrderItemProxy($this->dataLayer);
        $orderItem->setId($rs['ID']);
        $orderItem->setArticleId($rs["ID_ARTICOLO"]);
        $orderItem->setQuantity($rs["QUANTITA"]);
        return $orderItem;
    }



}

?>
