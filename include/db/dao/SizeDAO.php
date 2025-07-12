<?php

require_once("include/model/proxy/SizeProxy.php");


class SizeDAO extends DAO {


    private PDOStatement $stmtGetSizeById;
    private PDOStatement $stmtGetAllSizes;
    private PDOStatement $stmtGetAvailableSizeFromProductId;



    // Costruttore
    public function __construct(?DataLayer $dataLayer) {
        parent::__construct($dataLayer);
        $this->init();
    }


    // Inizializzazione degli statement
    public function init(): void {
        $this->stmtGetSizeById = $this->conn->prepare("SELECT * FROM TAGLIA WHERE ID = ?;");
        $this->stmtGetAllSizes = $this->conn->prepare("SELECT * FROM TAGLIA;");
        $this->stmtGetAvailableSizeFromProductId = $this->conn->prepare("SELECT DISTINCT ID_TAGLIA, TAGLIA FROM ARTICOLO_PRODOTTO_COMPLETO WHERE ID_PRODOTTO = ?;");
    }


    // Statement

    /**
     * 
     * 
     * 
     * 
     * 
     */
    public function getSizeById(int $id){
        $this->stmtGetSizeById->bindValue(1, $id, PDO::PARAM_INT);
        $this->stmtGetSizeById->execute();

        $rs = $this->stmtGetSizeById->fetch(PDO::FETCH_ASSOC);

        return $rs ? $this->createSize($rs) : null;
    }
    /**
     * 
     * 
     * 
     * 
     * 
     */
    public function getAvailableSizeFromProductId(?int $product_id): array {
        $this->stmtGetAvailableSizeFromProductId->bindValue(1, $product_id, PDO::PARAM_INT);
        $this->stmtGetAvailableSizeFromProductId->execute();
        $result = [];

        while ($rs = $this->stmtGetAvailableSizeFromProductId->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $this->getSizeById($rs["ID_TAGLIA"]);
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
    public function getAllSizes(): array {
        $this->stmtGetAllSizes->execute();
        $result = [];

        while ($rs = $this->stmtGetAllSizes->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $this->createSize($rs);
        }
        return $result;
    }

    // Metodi privati

    private function createSize(array $rs): Size {
        $size = new SizeProxy($this->dataLayer);
        $size->setId($rs['ID']);
        $size->setSize($rs["TAGLIA"]);
        return $size;
    }



}

?>
