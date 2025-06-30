<?php

require_once("include/model/proxy/PaymentProxy.php");


class PaymentDAO extends DAO{

    private PDOStatement $stmtGetPaymentById;
    private PDOStatement $stmtGetAllPayments;
    private PDOStatement $stmtGetPaymentByName;
    private PDOStatement $stmtInsertPayment;
    private PDOStatement $stmtUpdatePayment;
    private PDOStatement $stmtDeletePayment;

    // Costruttore
    public function __construct(?DataLayer $dataLayer) {
        parent::__construct($dataLayer);
        $this->init();
    }



    // Inizializzazione degli statement
    public function init(): void {
        $this->stmtGetPaymentById = $this->conn->prepare("SELECT * FROM PAGAMENTO WHERE ID = ?;");
        $this->stmtGetAllPayments = $this->conn->prepare("SELECT * FROM PAGAMENTO;");
        $this->stmtGetPaymentByName = $this->conn->prepare("SELECT * FROM PAGAMENTO WHERE NAME LIKE ?;");
        $this->stmtInsertPayment = $this->conn->prepare("INSERT INTO PAGAMENTO (NOME) VALUES (?);");
        $this->stmtUpdatePayment = $this->conn->prepare("UPDATE PAGAMENTO SET NOME = ? WHERE ID = ?;");
        $this->stmtDeletePayment = $this->conn->prepare("DELETE FROM PAGAMENTO WHERE ID = ?;");
    }


    // Statemetn

    /**
     * 
     * 
     * 
     * 
     * 
     */
    public function getPaymentById(int $id){
        $this->stmtGetPaymentById->bindValue(1, $id, PDO::PARAM_INT);
        $this->stmtGetPaymentById->execute();

        $rs = $this->stmtGetPaymentById->fetch(PDO::FETCH_ASSOC);

        return $rs ? $this->createPayment($rs) : null;
    }
    /**
     * 
     * 
     * 
     * 
     * 
     */
    public function getAllPayments(): array {
        $this->stmtGetAllPayments->execute();
        $result = [];

        while ($rs = $this->stmtGetAllPayments->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $this->createPayment($rs);
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
    public function getPaymentByName(string $name): ?Payment {
        $this->stmtGetPaymentByName->bindValue(1, $name, PDO::PARAM_STR);
        $this->stmtGetPaymentByName->execute();
        $rs = $this->stmtGetPaymentByName->fetch(PDO::FETCH_ASSOC);

        return $rs ? $this->createPayment($rs) : null;
    }
    /**
     * 
     * 
     * 
     * 
     * 
     */
    public function storePayment(Payment $payment): bool {
        if ($payment->getId() !== null) { 
            $this->stmtUpdatePayment->bindValue(1, $payment->getName(), PDO::PARAM_STR);
            $this->stmtUpdatePayment->bindValue(5, $payment->getId(), PDO::PARAM_INT);
            
            return $this->stmtUpdatePayment->execute();
        } else { 
            $this->stmtInsertPayment->bindValue(1, $payment->getName(), PDO::PARAM_STR);

            return $this->stmtInsertPayment->execute();
        }
    }
    /**
     * 
     * 
     * 
     * 
     * 
     */
    public function deletePayment(Payment $payment): bool {
        $this->stmtDeletePayment->bindValue(1, $payment->getId(), PDO::PARAM_INT);
        return $this->stmtDeletePayment->execute();
    }



    // Metodi privati

    private function createPayment(array $rs): Payment {
        $payment = new PaymentProxy($this->dataLayer);
        $payment->setId($rs['ID']);
        $payment->setName($rs['NOME']);
        return $payment;
    }



}

?>
