<?php

require_once("include/model/proxy/DeliveryProxy.php");


class DeliveryDAO extends DAO{

    private PDOStatement $stmtGetDeliveryById;
    private PDOStatement $stmtGetAllDeliveries;
    private PDOStatement $stmtGetDeliveryByName;
    private PDOStatement $stmtInsertDelivery;
    private PDOStatement $stmtUpdateDelivery;
    private PDOStatement $stmtDeleteDelivery;

  


    // Costruttore
    public function __construct(?DataLayer $dataLayer) {
        parent::__construct($dataLayer);
        $this->init();
    }

    public function init(): void
    {
        $this->stmtGetDeliveryById = $this->conn->prepare("SELECT * FROM SPEDIZIONE WHERE ID = ?;");
        $this->stmtGetAllDeliveries = $this->conn->prepare("SELECT * FROM SPEDIZIONE;");
        $this->stmtGetDeliveryByName = $this->conn->prepare("SELECT * FROM SPEDIZIONE WHERE NAME LIKE ?;");
        $this->stmtInsertDelivery = $this->conn->prepare("INSERT INTO SPEDIZIONE (NOME) VALUES (?);");
        $this->stmtUpdateDelivery = $this->conn->prepare("UPDATE SPEDIZIONE SET NOME = ? WHERE ID = ?;");
        $this->stmtDeleteDelivery = $this->conn->prepare("DELETE FROM SPEDIZIONE WHERE ID = ?;");
    }




    public function getDeliveryById(int $id)
    {
        $this->stmtGetDeliveryById->bindValue(1, $id, PDO::PARAM_INT);
        $this->stmtGetDeliveryById->execute();

        $rs = $this->stmtGetDeliveryById->fetch(PDO::FETCH_ASSOC);

        return $rs ? $this->createDelivery($rs) : null;
    }


    public function getAllDeliveries(): array
    {
        $this->stmtGetAllDeliveries->execute();
        $result = [];

        while ($rs = $this->stmtGetAllDeliveries->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $this->createDelivery($rs);
        }
        return $result;
    }


    public function getDeliveryByName(string $name): ?Delivery
    {
        $this->stmtGetDeliveryByName->bindValue(1, $name, PDO::PARAM_STR);
        $this->stmtGetDeliveryByName->execute();
        $rs = $this->stmtGetDeliveryByName->fetch(PDO::FETCH_ASSOC);

        return $rs ? $this->createDelivery($rs) : null;
    }


    public function storeDelivery(Delivery $delivery): bool
    {
        if ($delivery->getId() !== null) { // Aggiorno la spedizione
            $this->stmtUpdateDelivery->bindValue(1, $delivery->getName(), PDO::PARAM_STR);
            $this->stmtUpdateDelivery->bindValue(5, $delivery->getId(), PDO::PARAM_INT);

            return $this->stmtUpdateDelivery->execute();
        } else {   // Inserisco la spedizione
            $this->stmtInsertDelivery->bindValue(1, $delivery->getName(), PDO::PARAM_STR);

            return $this->stmtInsertDelivery->execute();
        }
    }


    public function deleteDelivery(Delivery $delivery): bool
    {
        $this->stmtDeleteDelivery->bindValue(1, $delivery->getId(), PDO::PARAM_INT);
        return $this->stmtDeleteDelivery->execute();
    }



    private function createDelivery(array $rs): Delivery
    {
        $delivery = new DeliveryProxy($this->dataLayer);
        $delivery->setId($rs['ID']);
        $delivery->setName($rs['NOME']);
        $delivery->setPrice($rs['PREZZO']);
        return $delivery;
    }
}
