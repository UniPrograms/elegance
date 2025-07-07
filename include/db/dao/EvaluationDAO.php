<?php

require_once("include/model/proxy/EvaluationProxy.php");   


class EvaluationDAO extends DAO{

    private PDOStatement $stmtGetEvaluationById;
    private PDOStatement $stmtGetAllEvaluations;
    private PDOStatement $stmtGetEvaluationByProduct;
    private PDOStatement $stmtGetEvaluationByUser;
    private PDOStatement $stmtInsertEvaluation;
    private PDOStatement $stmtUpdateEvaluation;
    private PDOStatement $stmtDeleteEvaluation;



    // Costruttore
    public function __construct(?DataLayer $dataLayer) {
        parent::__construct($dataLayer);
        $this->init();
    }


    // Inizializzazione degli statement
    public function init(): void {
        $this->stmtGetEvaluationById = $this->conn->prepare("SELECT * FROM VALUTAZIONE WHERE ID = ?;");
        $this->stmtGetAllEvaluations = $this->conn->prepare("SELECT * FROM VALUTAZIONE;");
        $this->stmtGetEvaluationByProduct = $this->conn->prepare("SELECT * FROM VALUTAZIONE WHERE ID_PRODOTTO = ?;");
        $this->stmtGetEvaluationByUser = $this->conn->prepare("SELECT * FROM VALUTAZIONE WHERE ID_UTENTE = ?;");
        $this->stmtInsertEvaluation = $this->conn->prepare("INSERT INTO VALUTAZIONE (STELLE, ID_PRODOTTO, ID_UTENTE) VALUES (?,?,?);");
        $this->stmtUpdateEvaluation = $this->conn->prepare("UPDATE VALUTAZIONE SET STELLE = ?, ID_PRODOTTO = ?, ID_UTENTE = ? WHERE ID = ?;");
        $this->stmtDeleteEvaluation = $this->conn->prepare("DELETE FROM VALUTAZIONE WHERE ID = ?;");
    }

    /**
     * 
     * 
     * 
     * 
     * 
     */
    public function getEvaluationById(int $id){
        $this->stmtGetEvaluationById->bindValue(1, $id, PDO::PARAM_INT);
        $this->stmtGetEvaluationById->execute();

        $rs = $this->stmtGetEvaluationById->fetch(PDO::FETCH_ASSOC);

        return $rs ? $this->createEvaluation($rs) : null;
    }
    /**
     * 
     * 
     * 
     * 
     * 
     */
    public function getAllEvaluations(): array {
        $this->stmtGetAllEvaluations->execute();
        $result = [];

        while ($rs = $this->stmtGetAllEvaluations->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $this->createEvaluation($rs);
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
    public function getEvaluationByProduct(Product $product): array {
        $this->stmtGetEvaluationByProduct->bindValue(1, $product->getId(), PDO::PARAM_STR);
        $this->stmtGetEvaluationByProduct->execute();

        $result = [];

        while ($rs = $this->stmtGetEvaluationByProduct->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $this->createEvaluation($rs);
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
    public function getEvaluationByUser(User $user): array {
        $this->stmtGetEvaluationByUser->bindValue(1, $user->getId(), PDO::PARAM_STR);
        $this->stmtGetEvaluationByUser->execute();

        $result = [];

        while ($rs = $this->stmtGetEvaluationByUser->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $this->createEvaluation($rs);
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
    public function storeEvaluation(Evaluation $evaluation): bool {
        if ($evaluation->getId() !== null) { 
            $this->stmtUpdateEvaluation->bindValue(1, $evaluation->getStar(), PDO::PARAM_INT);
            $this->stmtUpdateEvaluation->bindValue(2, $evaluation->getProduct()->getId(), PDO::PARAM_INT);
            $this->stmtUpdateEvaluation->bindValue(3, $evaluation->getUser()->getId(), PDO::PARAM_INT);
            $this->stmtUpdateEvaluation->bindValue(4, $evaluation->getId(), PDO::PARAM_INT);

            return $this->stmtUpdateEvaluation->execute();
        } else {
            $this->stmtInsertEvaluation->bindValue(1, $evaluation->getStar(), PDO::PARAM_INT);
            $this->stmtInsertEvaluation->bindValue(2, $evaluation->getProduct()->getId(), PDO::PARAM_INT);
            $this->stmtInsertEvaluation->bindValue(3, $evaluation->getUser()->getId(), PDO::PARAM_INT);

            return $this->stmtInsertEvaluation->execute();
        }
    }
    /**
     * 
     * 
     * 
     * 
     * 
     */
    public function deleteEvaluation(Evaluation $Evaluation): bool {
        $this->stmtDeleteEvaluation->bindValue(1, $Evaluation->getId(), PDO::PARAM_INT);
        return $this->stmtDeleteEvaluation->execute();
    }



    // Metodi privati

    private function createEvaluation(array $rs): Evaluation {
        $evaluation = new EvaluationProxy($this->dataLayer);
        $evaluation->setId($rs['ID']);
        $evaluation->setStar($rs['STELLE']);
        $evaluation->setProductId($rs["ID_PRODOTTO"]);
        $evaluation->setUserId($rs["ID_UTENTE"]);
        return $evaluation;
    }



}

?>
