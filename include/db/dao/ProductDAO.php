<?php

require_once("include/model/proxy/ProductProxy.php");


class ProductDAO extends DAO{



    private PDOStatement $stmtGetProductById;
    private PDOStatement $stmtGetAllProducts;
    private PDOStatement $stmtGetProductByName;
    private PDOStatement $stmtGetProductByNameInRange;
    private PDOStatement $stmtGetProductByCategory;
    private PDOStatement $stmtGetProductByCategoryInRange;
    private PDOStatement $stmtGetProductByProductor;
    private PDOStatement $stmtGetProductByProductorInRange;
    private PDOStatement $stmtGetPopularProduct;
    private PDOStatement $stmtInsertProduct;
    private PDOStatement $stmtUpdateProduct;
    private PDOStatement $stmtDeleteProduct;


    // Costruttore
    public function __construct(?DataLayer $dataLayer) {
        parent::__construct($dataLayer);
        $this->init();
    }


    // Inizializzazione degli Statement
    public function init(): void {
        $this->stmtGetProductById = $this->conn->prepare("SELECT * FROM PRODOTTO WHERE ID = ?;");
        $this->stmtGetAllProducts = $this->conn->prepare("SELECT * FROM PRODOTTO;");
        $this->stmtGetProductByName = $this->conn->prepare("SELECT * FROM PRODOTTO WHERE NOME LIKE ?;");
        $this->stmtGetProductByNameInRange = $this->conn->prepare("SELECT * FROM PRODOTTO WHERE NOME LIKE ? LIMIT ? OFFSET ?;");
        $this->stmtGetProductByCategory = $this->conn->prepare("SELECT * FROM PRODOTTO WHERE ID_CATEGORIA = ?;");
        $this->stmtGetProductByCategoryInRange = $this->conn->prepare("SELECT * FROM PRODOTTO WHERE ID_CATEGORIA = ? LIMIT ? OFFSET ?;");
        $this->stmtGetProductByProductor = $this->conn->prepare("SELECT * FROM PRODOTTO WHERE ID_PRODUTTORE = ?;");
        $this->stmtGetProductByProductorInRange = $this->conn->prepare("SELECT * FROM PRODOTTO WHERE ID_PRODUTTORE = ? LIMIT ? OFFSET ?;");
        $this->stmtInsertProduct = $this->conn->prepare("INSERT INTO PRODOTTO (NOME, PREZZO, DESCRIZIONE, ID_PRODUTTORE, ID_CATEGORIA) VALUES (?, ?, ?, ?, ?);");
        $this->stmtUpdateProduct = $this->conn->prepare("UPDATE PRODOTTO SET NOME = ?, PREZZO = ?, DESCRIZIONE = ?, ID_PRODUTTORE = ?, ID_CATEGORIA = ? WHERE ID = ?;");
        $this->stmtDeleteProduct = $this->conn->prepare("DELETE FROM PRODOTTO WHERE ID = ?;");
        //$this->stmtGetPopularProduct = $this->conn->prepare("");
    }


    /*
        -- Query per prendere i prodotti più popolari in base al sesso
        SELECT P.*, A.ID AS ID_ARTICOLO, SUM(OA.QUANTITA) AS QUANTITA FROM ORDINE_ARTICOLO AS OA 
        JOIN ARTICOLO AS A ON A.ID = OA.ID_ARTICOLO
        JOIN PRODOTTO AS P ON P.ID = A.ID_PRODOTTO
        WHERE P.ID_SESSO = 3
        GROUP BY ID_ARTICOLO ORDER BY QUANTITA DESC LIMIT 4;
    */ 



    public function getProductById(int $id): ?Product {
        $this->stmtGetProductById->bindValue(1, $id, PDO::PARAM_INT);
        $this->stmtGetProductById->execute();

        $rs = $this->stmtGetProductById->fetch(PDO::FETCH_ASSOC);

        return $rs ? $this->createProduct($rs) : null;
    }
    /**
    * 
    * 
    * 
    * 
    * 
    */
    public function getAllProduct(): array{
        $this->stmtGetAllProducts->execute();
        $result = [];

        while ($rs = $this->stmtGetAllProducts->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $this->createProduct($rs);
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
    public function getProductByName(string $name, ?int $offset = null, ?int $limit = null): array {
        if($offset != null && $limit != null){
            $stmt = $this->stmtGetProductByNameInRange;
            $stmt->bindValue(1, '%' . $name . '%', PDO::PARAM_STR);
            $stmt->bindValue(2, $limit, PDO::PARAM_INT);
            $stmt->bindValue(3, $offset, PDO::PARAM_INT);
        }
        else{
            // Usa la query senza paginazione
            $stmt = $this->stmtGetProductByName;
            $stmt->bindValue(1, '%' . $name . '%', PDO::PARAM_STR);
        }
        $stmt->execute();
        $result = [];

        while ($rs = $this->stmtGetProductByName->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $this->createProduct($rs);
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
    public function getProductByCategory(Category $category, ?int $offset = null, ?int $limit = null): array {
        if ($limit !== null && $offset !== null) {
            $stmt = $this->stmtGetProductByCategoryInRange;
            $stmt->bindValue(1, $category->getId(), PDO::PARAM_INT);
            $stmt->bindValue(2, $limit, PDO::PARAM_INT);
            $stmt->bindValue(3, $offset, PDO::PARAM_INT);
        } else {
            $stmt = $this->stmtGetProductByCategory;
            $stmt->bindValue(1, $category->getId(), PDO::PARAM_INT);
        }
    
        $stmt->execute();
        $result = [];
    
        while ($rs = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $this->createProduct($rs);
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
    public function getProductByProductor(Productor $productor, ?int $offset = null, ?int $limit = null): array {
        if ($limit !== null && $offset !== null) {
            $stmt = $this->stmtGetProductByProductorInRange;
            $stmt->bindValue(1, $productor->getId(), PDO::PARAM_INT);
            $stmt->bindValue(2, $limit, PDO::PARAM_INT);
            $stmt->bindValue(3, $offset, PDO::PARAM_INT);
        } else {
            $stmt = $this->stmtGetProductByProductor;
            $stmt->bindValue(1, $productor->getId(), PDO::PARAM_INT);
        }
    
        $stmt->execute();
        $result = [];
    
        while ($rs = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $this->createProduct($rs);
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
    public function storeProduct(Product $product): bool {
        if ($product->getId() !== null) { // Aggiorno il prodotto
            $this->stmtUpdateProduct->bindValue(1, $product->getName(), PDO::PARAM_STR);
            $this->stmtUpdateProduct->bindValue(2, $product->getPrice(), PDO::PARAM_STR);
            $this->stmtUpdateProduct->bindValue(3, $product->getDescription(), PDO::PARAM_STR);
            $this->stmtUpdateProduct->bindValue(4, $product->getProductor()->getId(), PDO::PARAM_INT);
            $this->stmtUpdateProduct->bindValue(5, $product->getCategory()->getId(), PDO::PARAM_INT);
            $this->stmtUpdateProduct->bindValue(6, $product->getId(), PDO::PARAM_INT);
            
            return $this->stmtUpdateProduct->execute();
        } else {   // Inserisco il prodotto
            $this->stmtInsertProduct->bindValue(1, $product->getName(), PDO::PARAM_STR);
            $this->stmtInsertProduct->bindValue(2, $product->getPrice(), PDO::PARAM_STR);
            $this->stmtInsertProduct->bindValue(3, $product->getDescription(), PDO::PARAM_STR);
            $this->stmtInsertProduct->bindValue(4, $product->getProductor()->getId(), PDO::PARAM_INT);
            $this->stmtInsertProduct->bindValue(5, $product->getCategory()->getId(), PDO::PARAM_INT);

            return $this->stmtInsertProduct->execute();
        }
    }
    /**
    * 
    * 
    * 
    * 
    * 
    */
    public function deleteProduct(Product $product): bool {
        $this->stmtDeleteProduct->bindValue(1, $product->getId(), PDO::PARAM_INT);
        return $this->stmtDeleteProduct->execute();
    }


    // Metodi privati
    private function createProduct(array $rs): Product{
        $product = new ProductProxy($this->dataLayer);
        $product->setId($rs["ID"]);
        $product->setName(($rs["NOME"]));
        $product->setPrice($rs["PREZZO"]);
        $product->setSexId($rs["ID_SESSO"]);
        $product->setCategoryId($rs["ID_CATEGORIA"]);
        $product->setProductorId($rs["ID_PRODUTTORE"]);
        $product->setDescription($rs["DESCRIZIONE"]);
        $product->setCopertina($rs["COPERTINA"]);
        return $product;


    }





}

?>
