<?php

require_once("include/model/proxy/FeatureProxy.php");



class FeatureDAO extends DAO{

    private PDOStatement $stmtGetFeatureById;
    private PDOStatement $stmtGetAllFeatures;
    private PDOStatement $stmtInsertFeature;
    private PDOStatement $stmtUpdateFeature;
    private PDOStatement $stmtDeleteFeature;
    


    // Costruttore
    public function __construct(?DataLayer $dataLayer) {
        parent::__construct($dataLayer);
        $this->init();
    }


    // Inizializzazione degli statement
    public function init(): void {
        $this->stmtGetFeatureById = $this->conn->prepare("SELECT * FROM CARATTERISTICA WHERE ID = ?;");
        $this->stmtGetAllFeatures = $this->conn->prepare("SELECT * FROM CARATTERISTICA");
        $this->stmtInsertFeature = $this->conn->prepare("INSERT INTO CARATTERISTICA (NOME) VALUES (?);");
        $this->stmtUpdateFeature = $this->conn->prepare("UPDATE CARATTERISTICA SET NOME = ? WHERE ID = ?;");
        $this->stmtDeleteFeature = $this->conn->prepare("DELETE FROM CARATTERISTICA WHERE ID = ?;");
    }


    // Statemetn

    /**
     * 
     * 
     * 
     * 
     * 
     */
    public function getFeatureById(int $id): ?Feature{
        $this->stmtGetFeatureById->bindValue(1, $id, PDO::PARAM_INT);
        $this->stmtGetFeatureById->execute();

        $rs = $this->stmtGetFeatureById->fetch(PDO::FETCH_ASSOC);

        return $rs ? $this->createFeature($rs) : null;
    }
    /**
     * 
     * 
     * 
     * 
     * 
     */
    public function getAllFeatures(): array {
        $this->stmtGetAllFeatures->execute();
        $result = [];

        while ($rs = $this->stmtGetAllFeatures->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $this->createFeature($rs);
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
    public function storeFeature(Feature $feature): bool {
        if ($feature->getId() !== null) { // Aggiorno la caratteristica
            $this->stmtUpdateFeature->bindValue(1, $feature->getName(), PDO::PARAM_STR);
            $this->stmtUpdateFeature->bindValue(2, $feature->getId(), PDO::PARAM_INT);
            
            return $this->stmtUpdateFeature->execute();
        } else {   // Inserisco la caratteristica
            $this->stmtInsertFeature->bindValue(1, $feature->getName(), PDO::PARAM_STR);

            return $this->stmtInsertFeature->execute();
        }
    }
    /**
     * 
     * 
     * 
     * 
     * 
     */
    public function deleteFeature(Feature $feature): bool {
        $this->stmtDeleteFeature->bindValue(1, $feature->getId(), PDO::PARAM_INT);
        return $this->stmtDeleteFeature->execute();
    }



    // Metodi privati

    private function createFeature(array $rs): Feature {
        $feature = new FeatureProxy($this->dataLayer);
        $feature->setId($rs['ID']);
        $feature->setName($rs['NOME']);
        return $feature;
    }

}

?>
