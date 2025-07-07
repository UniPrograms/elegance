<?php

require_once("include/model/proxy/AddressProxy.php");


class AddressDAO extends DAO{



    private PDOStatement $stmtGetAddressById;
    private PDOStatement $stmtInsertAddress;


    // Costruttore
    public function __construct(?DataLayer $dataLayer) {
        parent::__construct($dataLayer);
        $this->init();
    }


    // Inizializzazione degli Statement
    public function init(): void {
        $this->stmtGetAddressById = $this->conn->prepare("SELECT * FROM INDIRIZZO WHERE ID = ?;");
        $this->stmtInsertAddress = $this->conn->prepare("INSERT INTO INDIRIZZO (NAZIONE, CITTA, VIA, CIVICO, CAP) VALUES(?, ?, ?, ?, ?);");
        
    }



    public function getAddressById(int $id): ?Address {
        $this->stmtGetAddressById->bindValue(1, $id, PDO::PARAM_INT);
        $this->stmtGetAddressById->execute();

        $rs = $this->stmtGetAddressById->fetch(PDO::FETCH_ASSOC);

        return $rs ? $this->createAddress($rs) : null;
    }  
    /**
    * 
    * 
    * 
    * 
    * 
    */
    public function storeArticle(Address $address): bool {
        // Inserisco il prodotto
        $this->stmtInsertAddress->bindValue(1, $address->getNazione(), PDO::PARAM_STR);
        $this->stmtInsertAddress->bindValue(2, $address->getCitta(), PDO::PARAM_STR);
        $this->stmtInsertAddress->bindValue(3, $address->getVia(), PDO::PARAM_STR);
        $this->stmtInsertAddress->bindValue(4, $address->getCivico(), PDO::PARAM_STR);
        $this->stmtInsertAddress->bindValue(4, $address->getCAP(), PDO::PARAM_INT);
        return $this->stmtInsertAddress->execute();
        
    }


    // Metodi privati
    private function createAddress(array $rs): Address{
        $address = new AddressProxy($this->dataLayer);
        $address->setId($rs["ID"]);
        $address->setNazione(($rs["NAZIONE"]));
        $address->setCitta($rs["CITTA"]);
        $address->setVia($rs["VIA"]);
        $address->setCivico($rs["CIVICO"]);
        $address->setCAP($rs["CAP"]);
        return $address;


    }





}

?>
