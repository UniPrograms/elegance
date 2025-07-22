<?php

require_once("include/model/proxy/ProductorProxy.php");


class ProductorDAO extends DAO {

    // Prepared Statement
    private PDOStatement $stmtGetProductorById;
    private PDOStatement $stmtGetAllProductores;
    private PDOStatement $stmtGetAllProductoresInRange;
    private PDOStatement $stmtGetProductorByName;
    private PDOStatement $stmtGetAllProductorsByGenericString;
    private PDOStatement $stmtInsertProductor;
    private PDOStatement $stmtUpdateProductor;
    private PDOStatement $stmtDeleteProductor;

   


    // Costruttore
    public function __construct(?DataLayer $dataLayer) {
        parent::__construct($dataLayer);
        $this->init();
    }

    public function init(): void {
        $this->stmtGetProductorById = $this->conn->prepare("SELECT * FROM PRODUTTORE WHERE ID = ?;");
        $this->stmtGetAllProductores = $this->conn->prepare("SELECT * FROM PRODUTTORE;");
        $this->stmtGetAllProductoresInRange = $this->conn->prepare("SELECT * FROM PRODUTTORE LIMIT ? OFFSET ?;");
        $this->stmtGetProductorByName = $this->conn->prepare("SELECT * FROM PRODUTTORE WHERE NAME LIKE ?;");
        $this->stmtGetAllProductorsByGenericString = $this->conn->prepare("SELECT * FROM PRODUTTORE WHERE NOME LIKE ?;");
        $this->stmtInsertProductor = $this->conn->prepare("INSERT INTO PRODUTTORE (NOME) VALUES (?);");
        $this->stmtUpdateProductor = $this->conn->prepare("UPDATE PRODUTTORE SET NOME = ? WHERE ID = ?;");
        $this->stmtDeleteProductor = $this->conn->prepare("DELETE FROM PRODUTTORE WHERE ID = ?;");
    }


    // Inizializzazione degli statement

     /**
     * 
     * 
     * 
     * 
     * 
     */
    public function getProductorById(int $id){
        $this->stmtGetProductorById->bindValue(1, $id, PDO::PARAM_INT);
        $this->stmtGetProductorById->execute();

        $rs = $this->stmtGetProductorById->fetch(PDO::FETCH_ASSOC);

        return $rs ? $this->createProductor($rs) : null;
    }
     /**
     * 
     * 
     * 
     * 
     * 
     */
    public function getAllProductores(?int $limit = null, ?int $offset = null): array {
        if($limit !== null && $offset !== null){
            $stmt = $this->stmtGetAllProductoresInRange;
            $stmt->bindValue(1, $limit, PDO::PARAM_INT);
            $stmt->bindValue(2, $offset, PDO::PARAM_INT);   
        }
        else{
            $stmt = $this->stmtGetAllProductores;
        }
        
        $stmt->execute();

        $result = [];
        while ($rs = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $this->createProductor($rs);
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
    public function getProductorByName(string $name): ?Productor {
        $this->stmtGetProductorByName->bindValue(1, $name, PDO::PARAM_STR);
        $this->stmtGetProductorByName->execute();
        $rs = $this->stmtGetProductorByName->fetch(PDO::FETCH_ASSOC);

        return $rs ? $this->createProductor($rs) : null;
    }
    /**
     * 
     * 
     * 
     * 
     * 
     */
    public function getProductorsByGenericString(string $string): array {
        $this->stmtGetAllProductorsByGenericString->bindValue(1, '%'.$string.'%', PDO::PARAM_STR);
        $this->stmtGetAllProductorsByGenericString->execute();
        $this->stmtGetAllProductorsByGenericString->execute();
        $result = [];

        while ($rs = $this->stmtGetAllProductorsByGenericString->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $this->createProductor($rs);
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
    public function storeProductor(Productor $productor): ?Productor {
        if ($productor->getId() !== null) { // Aggiorno il produttore
            $this->stmtUpdateProductor->bindValue(1, $productor->getName(), PDO::PARAM_STR);
            $this->stmtUpdateProductor->bindValue(2, $productor->getId(), PDO::PARAM_INT);
            
            if($this->stmtUpdateProductor->execute()){
                return $productor;
            }
        } else {   // Inserisco il produttore
            $this->stmtInsertProductor->bindValue(1, $productor->getName(), PDO::PARAM_STR);

            if($this->stmtInsertProductor->execute()){
                $productor->setId($this->conn->lastInsertId());
                return $productor;
            }
        }
        return null;
    }
     /**
     * 
     * 
     * 
     * 
     * 
     */
    public function deleteProductor(Productor $productor): bool {
        $this->stmtDeleteProductor->bindValue(1, $productor->getId(), PDO::PARAM_INT);
        return $this->stmtDeleteProductor->execute();
    }
    /**
     * 
     * 
     * 
     * 
     * 
     */
    public function deleteProductorById(int $id): bool {
        $this->stmtDeleteProductor->bindValue(1, $id, PDO::PARAM_INT);
        return $this->stmtDeleteProductor->execute();
    }


    // Metodi privati
    private function createProductor(array $rs): Productor {
        $productor = new ProductorProxy($this->dataLayer);
        $productor->setId($rs['ID']);
        $productor->setName($rs['NOME']);
        $productor->setLogo($rs['LOGO_URL']);
        return $productor;
    }



}

?>
