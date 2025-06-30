<?php

require_once("include/model/proxy/ProductFeatureProxy.php");


class ProductFeatureDAO extends DAO{

    private PDOStatement $stmtGetProductFeatureById;
    private PDOStatement $stmtGetAllProductFeatures;
    private PDOStatement $stmtGetProductFeaturesByProduct;
    private PDOStatement $stmtInsertProductFeature;
    private PDOStatement $stmtUpdateProductFeature;
    private PDOStatement $stmtDeleteProductFeature;
    


    // Costruttore
    public function __construct(?DataLayer $dataLayer) {
        parent::__construct($dataLayer);
        $this->init();
    }



    // Inizializzazione degli statement
    public function init(): void {
        $this->stmtGetProductFeatureById = $this->conn->prepare("SELECT * FROM CARATTERISTICA_PRODOTTO WHERE ID = ?;");
        $this->stmtGetAllProductFeatures = $this->conn->prepare("SELECT * FROM CARATTERISTICA_PRODOTTO");
        $this->stmtGetProductFeaturesByProduct = $this->conn->prepare("SELECT * FROM CARATTERISTICA_PRODOTTO WHERE ID_PRODOTTO = ?;");
        $this->stmtInsertProductFeature = $this->conn->prepare("INSERT INTO CARATTERISTICA_PRODOTTO(ID_PRODOTTO, ID_CARATTERISTICA, TESTO) VALUES (?,?,?);");
        $this->stmtUpdateProductFeature = $this->conn->prepare("UPDATE CARATTERISTICA_PRODOTTO SET ID_PRODOTTO = ?, ID_CARATTERISTICA = ?, TESTO = ? WHERE ID = ?;");
        $this->stmtDeleteProductFeature = $this->conn->prepare("DELETE FROM CARATTERISTICA_PRODOTTO WHERE ID = ?;");
    }


    // Statemetn

    /**
     * 
     * 
     * 
     * 
     * 
     */
    public function getProductFeatureById(int $id): ?ProductFeature{
        $this->stmtGetProductFeatureById->bindValue(1, $id, PDO::PARAM_INT);
        $this->stmtGetProductFeatureById->execute();

        $rs = $this->stmtGetProductFeatureById->fetch(PDO::FETCH_ASSOC);

        return $rs ? $this->createProductFeature($rs) : null;
    }
    /**
     * 
     * 
     * 
     * 
     * 
     */
    public function getAllProductFeatures(): array {
        $this->stmtGetAllProductFeatures->execute();
        $result = [];

        while ($rs = $this->stmtGetAllProductFeatures->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $this->createProductFeature($rs);
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
    public function getProductFeaturesByProduct(Product $product): array {
        $this->stmtGetProductFeaturesByProduct->bindValue(1, $product->getId(), PDO::PARAM_INT);
        $this->stmtGetProductFeaturesByProduct->execute();

        $result = [];
        while ($rs = $this->stmtGetProductFeaturesByProduct->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $this->createProductFeature($rs);
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
    public function storeProductFeature(ProductFeature $productFeature, Product $product): bool {
        if ($productFeature->getId() !== null) { // Aggiorno la caratteristica del prodotto
            $this->stmtUpdateProductFeature->bindValue(1, $product->getId(), PDO::PARAM_INT);
            $this->stmtUpdateProductFeature->bindValue(2, $productFeature->getFeature()->getId(), PDO::PARAM_INT);
            $this->stmtUpdateProductFeature->bindValue(3, $productFeature->getDescription(), PDO::PARAM_STR);
            $this->stmtUpdateProductFeature->bindValue(4, $productFeature->getId(), PDO::PARAM_INT);
            
            return $this->stmtUpdateProductFeature->execute();
        } else {   // Inserisco la caratteristica del prodotto
            $this->stmtInsertProductFeature->bindValue(1, $product->getId(), PDO::PARAM_INT);
            $this->stmtInsertProductFeature->bindValue(2, $productFeature->getFeature()->getId(), PDO::PARAM_INT);
            $this->stmtInsertProductFeature->bindValue(3, $productFeature->getDescription(), PDO::PARAM_STR);

            return $this->stmtInsertProductFeature->execute();
        }
    }
    /**
     * 
     * 
     * 
     * 
     * 
     */
    public function deleteProductFeature(ProductFeature $productFeature): bool {
        $this->stmtDeleteProductFeature->bindValue(1, $productFeature->getId(), PDO::PARAM_INT);
        return $this->stmtDeleteProductFeature->execute();
    }



    // Metodi privati

    private function createProductFeature(array $rs): ProductFeature {
        $productFeature = new ProductFeatureProxy($this->dataLayer);
        $productFeature->setId($rs['ID']);
        $productFeature->setDescription($rs["TESTO"]);
        $productFeature->setFeatureId($rs["ID_CARATTERISTICA"]);
        return $productFeature;
    }

}

?>
