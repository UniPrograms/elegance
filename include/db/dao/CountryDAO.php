<?php

require_once("include/model/proxy/CountryProxy.php");


class CountryDAO extends DAO{


    private PDOStatement $stmtGetCountryById;
    private PDOStatement $stmtGetAllCountries;
    private PDOStatement $stmtGetCountryByName;
    private PDOStatement $stmtInsertCountry;
    private PDOStatement $stmtUpdateCountry;
    private PDOStatement $stmtDeleteCountry;


    // Costruttore
    public function __construct(?DataLayer $dataLayer) {
    parent::__construct($dataLayer);
    $this->init();
}



    // Inizializzazione degli statement
    public function init(): void {
        $this->stmtGetCountryById = $this->conn->prepare("SELECT * FROM NAZIONE WHERE ID = ?;");
        $this->stmtGetAllCountries = $this->conn->prepare("SELECT * FROM NAZIONE;");
        $this->stmtGetCountryByName = $this->conn->prepare("SELECT * FROM NAZIONE WHERE NOME LIKE ?;");
        $this->stmtInsertCountry = $this->conn->prepare("INSERT INTO NAZIONE (NOME) VALUES (?);");
        $this->stmtUpdateCountry = $this->conn->prepare("UPDATE NAZIONE SET NOME = ? WHERE ID = ?;");
        $this->stmtDeleteCountry = $this->conn->prepare("DELETE FROM NAZIONE WHERE ID = ?;");
    }


    // Statemetn

    /**
     * 
     * 
     * 
     * 
     * 
     */
    public function getCountryById(int $id){
        $this->stmtGetCountryById->bindValue(1, $id, PDO::PARAM_INT);
        $this->stmtGetCountryById->execute();

        $rs = $this->stmtGetCountryById->fetch(PDO::FETCH_ASSOC);

        return $rs ? $this->createCountry($rs) : null;
    }
    /**
     * 
     * 
     * 
     * 
     * 
     */
    public function getAllCountries(): array {
        $this->stmtGetAllCountries->execute();
        $result = [];

        while ($rs = $this->stmtGetAllCountries->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $this->createCountry($rs);
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
    public function getCountryByName(string $name): ?Country {
        $this->stmtGetCountryByName->bindValue(1, '%'.$name.'%', PDO::PARAM_STR);
        $this->stmtGetCountryByName->execute();
        $rs = $this->stmtGetCountryByName->fetch(PDO::FETCH_ASSOC);

        return $rs ? $this->createCountry($rs) : null;
    }
    /**
     * 
     * 
     * 
     * 
     * 
     */
    public function storeCountry(Country $country): ?Country {
        if ($country->getId() !== null) { 
            $this->stmtUpdateCountry->bindValue(1, $country->getName(), PDO::PARAM_STR);
            $this->stmtUpdateCountry->bindValue(5, $country->getId(), PDO::PARAM_INT);
            
            if($this->stmtUpdateCountry->execute()){
                return $country;
            }
        } else { 
            $this->stmtInsertCountry->bindValue(1, $country->getName(), PDO::PARAM_STR);

            if($this->stmtInsertCountry->execute()){
                $country->setId($this->conn->lastInsertId());
                return $country;
            }
        }
        return null;
    }
    /*
     * 
     * 
     * 
     * 
     * 
     */
    public function deleteCountry(Country $country): bool {
        $this->stmtDeleteCountry->bindValue(1, $country->getId(), PDO::PARAM_INT);
        return $this->stmtDeleteCountry->execute();
    }
    /*
     * 
     * 
     * 
     * 
     * 
     */
    public function deleteCountryById(int $id): bool {
        $this->stmtDeleteCountry->bindValue(1, $id, PDO::PARAM_INT);
        return $this->stmtDeleteCountry->execute();
    }



    // Metodi privati

    private function createCountry(array $rs): Country {
        $country = new CountryProxy($this->dataLayer);
        $country->setId($rs['ID']);
        $country->setName($rs['NOME']);
        return $country;
    }



}

?>
