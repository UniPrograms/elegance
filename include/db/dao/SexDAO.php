<?php

require_once("include/model/proxy/SexProxy.php");


class SexDAO extends DAO {


    private PDOStatement $stmtGetSexById;
    private PDOStatement $stmtGetAllSexs;



    // Costruttore
    public function __construct(?DataLayer $dataLayer) {
        parent::__construct($dataLayer);
        $this->init();
    }



    // Inizializzazione degli statement
    public function init(): void {
        $this->stmtGetSexById = $this->conn->prepare("SELECT * FROM SESSO WHERE ID = ?;");
        $this->stmtGetAllSexs = $this->conn->prepare("SELECT * FROM SESSO;");
    }


    // Statemetn

    /**
     * 
     * 
     * 
     * 
     * 
     */
    public function getSexById(int $id){
        $this->stmtGetSexById->bindValue(1, $id, PDO::PARAM_INT);
        $this->stmtGetSexById->execute();

        $rs = $this->stmtGetSexById->fetch(PDO::FETCH_ASSOC);

        return $rs ? $this->createSex($rs) : null;
    }
    /**
     * 
     * 
     * 
     * 
     * 
     */
    public function getAllSexs(): array {
        $this->stmtGetAllSexs->execute();
        $result = [];

        while ($rs = $this->stmtGetAllSexs->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $this->createSex($rs);
        }
        return $result;
    }


    // Metodi privati

    private function createSex(array $rs): Sex {
        $Sex = new SexProxy($this->dataLayer);
        $Sex->setId($rs['ID']);
        $Sex->setSex($rs["SESSO"]);
        return $Sex;
    }



}

?>
