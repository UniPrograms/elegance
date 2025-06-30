<?php

require_once("include/model/proxy/SizeProxy.php");


class SizeDAO extends DAO {


    private PDOStatement $stmtGetSizeById;
    private PDOStatement $stmtGetAllSizes;



    // Costruttore
    public function __construct(?DataLayer $dataLayer) {
        parent::__construct($dataLayer);
        $this->init();
    }


    // Inizializzazione degli statement
    public function init(): void {
        $this->stmtGetSizeById = $this->conn->prepare("SELECT * FROM TAGLIA WHERE ID = ?;");
        $this->stmtGetAllSizes = $this->conn->prepare("SELECT * FROM TAGLIA;");
    }


    // Statemetn

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
