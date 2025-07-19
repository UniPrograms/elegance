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
    private PDOStatement $stmtGetProductFiltered;
    private PDOStatement $stmtGetProductFilteredInRange;
    private PDOStatement $stmtGetPopularProduct;
    private PDOStatement $stmtGetPopularProductInRange;
    private PDOStatement $stmtGetPopularProductBySex;
    private PDOStatement $stmtGetPopularProductBySexInRange;
    private PDOStatement $stmtGetAllProductsByGenericString;
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
        $this->stmtGetProductById = $this->conn->prepare("SELECT * FROM PRODOTTO_COMPLETO WHERE ID_PRODOTTO = ?;");
        $this->stmtGetAllProducts = $this->conn->prepare("SELECT * FROM PRODOTTO_COMPLETO;");
        $this->stmtGetProductByName = $this->conn->prepare("SELECT * FROM PRODOTTO_COMPLETO WHERE NOME_PRODOTTO LIKE ?;");
        $this->stmtGetProductByNameInRange = $this->conn->prepare("SELECT * FROM PRODOTTO_COMPLETO WHERE NOME_PRODOTTO LIKE ? LIMIT ? OFFSET ?;");
        $this->stmtGetProductByCategory = $this->conn->prepare("SELECT * FROM PRODOTTO_COMPLETO WHERE ID_CATEGORIA = ?;");
        $this->stmtGetProductByCategoryInRange = $this->conn->prepare("SELECT * FROM PRODOTTO_COMPLETO WHERE ID_CATEGORIA = ? LIMIT ? OFFSET ?;");
        $this->stmtGetProductByProductor = $this->conn->prepare("SELECT * FROM PRODOTTO_COMPLETO WHERE ID_PRODUTTORE = ?;");
        $this->stmtGetProductByProductorInRange = $this->conn->prepare("SELECT * FROM PRODOTTO_COMPLETO WHERE ID_PRODUTTORE = ? LIMIT ? OFFSET ?;");
        $this->stmtInsertProduct = $this->conn->prepare("INSERT INTO PRODOTTO (NOME, PREZZO, DESCRIZIONE, ID_PRODUTTORE, ID_CATEGORIA, ID_SESSO) VALUES (?, ?, ?, ?, ?, ?);");
        $this->stmtUpdateProduct = $this->conn->prepare("UPDATE PRODOTTO SET NOME = ?, PREZZO = ?, DESCRIZIONE = ?, ID_PRODUTTORE = ?, ID_CATEGORIA = ?, ID_SESSO = ? WHERE ID = ?;");
        $this->stmtDeleteProduct = $this->conn->prepare("DELETE FROM PRODOTTO WHERE ID = ?;");
        $this->stmtGetPopularProduct = $this->conn->prepare("SELECT * FROM PRODOTTO_QUANTITA_VENDUTA;");
        $this->stmtGetPopularProductInRange = $this->conn->prepare("SELECT * FROM PRODOTTO_QUANTITA_VENDUTA LIMIT ? OFFSET ?;");
        $this->stmtGetPopularProductBySex= $this->conn->prepare("SELECT * FROM PRODOTTO_QUANTITA_VENDUTA WHERE ID_SESSO = ?;");
        $this->stmtGetPopularProductBySexInRange = $this->conn->prepare("SELECT * FROM PRODOTTO_QUANTITA_VENDUTA WHERE ID_SESSO = ? LIMIT ? OFFSET ?;");
        $this->stmtGetAllProductsByGenericString = $this->conn->prepare("SELECT * FROM PRODOTTO_COMPLETO WHERE NOME_PRODOTTO LIKE ? OR NOME_CATEGORIA LIKE ? OR 
                                                                                                               NOME_PRODUTTORE LIKE ?;");
        
        $this->stmtGetProductFiltered = $this->conn->prepare("SELECT DISTINCT ID_PRODOTTO FROM ARTICOLO_PRODOTTO_COMPLETO WHERE (? IS NULL OR NOME_PRODOTTO LIKE ?) AND 
                                                                                                                    (? IS NULL OR ID_CATEGORIA = ?) AND 
                                                                                                                    (? IS NULL OR ID_SESSO = ?) AND
                                                                                                                    (? IS NULL OR ID_COLORE = ?) AND
                                                                                                                    (? IS NULL OR ID_TAGLIA = ?) AND
                                                                                                                    (? IS NULL OR ID_PRODUTTORE = ?) AND
                                                                                                                    (? IS NULL OR PREZZO_PRODOTTO >= ?) AND 
                                                                                                                    (? IS NULL OR PREZZO_PRODOTTO <= ?);");
        $this->stmtGetProductFilteredInRange = $this->conn->prepare("SELECT DISTINCT ID_PRODOTTO FROM ARTICOLO_PRODOTTO_COMPLETO WHERE (? IS NULL OR NOME_PRODOTTO LIKE ?) AND 
                                                                                                                    (? IS NULL OR ID_CATEGORIA = ?) AND 
                                                                                                                    (? IS NULL OR ID_SESSO = ?) AND
                                                                                                                    (? IS NULL OR ID_COLORE = ?) AND
                                                                                                                    (? IS NULL OR ID_TAGLIA = ?) AND
                                                                                                                    (? IS NULL OR ID_PRODUTTORE = ?) AND
                                                                                                                    (? IS NULL OR PREZZO_PRODOTTO >= ?) AND 
                                                                                                                    (? IS NULL OR PREZZO_PRODOTTO <= ?) 
                                                                                                                    LIMIT ? OFFSET ?;");
        
    }


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
    public function getProductPopular(?int $offset = null, ?int $limit = null): array {
        if ($limit !== null && $offset !== null) {
            $stmt = $this->stmtGetPopularProductInRange;
            $stmt->bindValue(1, $limit, PDO::PARAM_INT);
            $stmt->bindValue(2, $offset, PDO::PARAM_INT);
        } else {
            $stmt = $this->stmtGetPopularProduct;
        }
    
        $stmt->execute();
        
        $result = [];
        while ($rs = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $this->getProductById($rs["ID"]);
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
    public function getProductPopularBySexId(int $sex_id, ?int $offset = null, ?int $limit = null): array {
        if ($limit !== null && $offset !== null) {
            $stmt = $this->stmtGetPopularProductBySexInRange;
            $stmt->bindValue(1, $sex_id, PDO::PARAM_INT);
            $stmt->bindValue(2, $limit, PDO::PARAM_INT);
            $stmt->bindValue(3, $offset, PDO::PARAM_INT);
        } else {
            $stmt = $this->stmtGetPopularProductBySex;
            $stmt->bindValue(1, $sex_id, PDO::PARAM_INT);
        }
    
        $stmt->execute();
        
        $result = [];
        while ($rs = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $this->getProductById($rs["ID"]);
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
    public function getProductFiltered(?string $name = null, ?int $categoryId = null, ?int $sexId = null, ?int $colorId = null, 
                                   ?int $sizeId = null, ?int $productorId = null, ?float $minPrice = null, ?float $maxPrice = null, 
                                   ?int $limit = null, ?int $offset = null): array {

        if ($limit === null && $offset === null) {
            $stmt = $this->stmtGetProductFiltered;
            $stmt->bindValue(1, $name);
            $stmt->bindValue(2, $name === null ? null : "%" . $name . "%");
            $stmt->bindValue(3, $categoryId);
            $stmt->bindValue(4, $categoryId);
            $stmt->bindValue(5, $sexId);
            $stmt->bindValue(6, $sexId);
            $stmt->bindValue(7, $colorId);
            $stmt->bindValue(8, $colorId);
            $stmt->bindValue(9, $sizeId);
            $stmt->bindValue(10, $sizeId);
            $stmt->bindValue(11, $productorId);
            $stmt->bindValue(12, $productorId);
            $stmt->bindValue(13, $minPrice);
            $stmt->bindValue(14, $minPrice);
            $stmt->bindValue(15, $maxPrice);
            $stmt->bindValue(16, $maxPrice);
        } else {
            $stmt = $this->stmtGetProductFilteredInRange;
            $stmt->bindValue(1, $name);
            $stmt->bindValue(2, $name === null ? null : "%" . $name . "%");
            $stmt->bindValue(3, $categoryId);
            $stmt->bindValue(4, $categoryId);
            $stmt->bindValue(5, $sexId);
            $stmt->bindValue(6, $sexId);
            $stmt->bindValue(7, $colorId);
            $stmt->bindValue(8, $colorId);
            $stmt->bindValue(9, $sizeId);
            $stmt->bindValue(10, $sizeId);
            $stmt->bindValue(11, $productorId);
            $stmt->bindValue(12, $productorId);
            $stmt->bindValue(13, $minPrice);
            $stmt->bindValue(14, $minPrice);
            $stmt->bindValue(15, $maxPrice);
            $stmt->bindValue(16, $maxPrice);
            $stmt->bindValue(17, $limit, PDO::PARAM_INT);
            $stmt->bindValue(18, $offset, PDO::PARAM_INT);
        }

        $stmt->execute();
    
        $result = [];
        while ($rs = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $this->getProductById($rs["ID_PRODOTTO"]);
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
     public function getAllProductsByGenericString(string $string): array {
        $this->stmtGetAllProductsByGenericString->bindValue(1, '%' . $string . '%', PDO::PARAM_STR);
        $this->stmtGetAllProductsByGenericString->bindValue(2, '%' . $string . '%', PDO::PARAM_STR);
        $this->stmtGetAllProductsByGenericString->bindValue(3, '%' . $string . '%', PDO::PARAM_STR);
        $this->stmtGetAllProductsByGenericString->execute();
        
        $result = [];
        while ($rs = $this->stmtGetAllProductsByGenericString->fetch(PDO::FETCH_ASSOC)) {
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
    public function getAllProductsByGenericStrings(array $strings): array {
        $result = [];
        foreach($strings as $string){
            foreach($this->getAllProductsByGenericString($string) as $product){
                $result[$product->getId()] = $product;
            }
        }
        return array_values($result);
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
            $this->stmtUpdateProduct->bindValue(6, $product->getSex()->getId(), PDO::PARAM_INT);
            $this->stmtUpdateProduct->bindValue(7, $product->getId(), PDO::PARAM_INT);
            
            return $this->stmtUpdateProduct->execute();
        } else {   // Inserisco il prodotto
            $this->stmtInsertProduct->bindValue(1, $product->getName(), PDO::PARAM_STR);
            $this->stmtInsertProduct->bindValue(2, $product->getPrice(), PDO::PARAM_STR);
            $this->stmtInsertProduct->bindValue(3, $product->getDescription(), PDO::PARAM_STR);
            $this->stmtInsertProduct->bindValue(4, $product->getProductor()->getId(), PDO::PARAM_INT);
            $this->stmtInsertProduct->bindValue(5, $product->getCategory()->getId(), PDO::PARAM_INT);
            $this->stmtUpdateProduct->bindValue(6, $product->getSex()->getId(), PDO::PARAM_INT);

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
    /**
    * 
    * 
    * 
    * 
    * 
    */
    public function deleteProductById(int $id): bool {
        $this->stmtDeleteProduct->bindValue(1, $id, PDO::PARAM_INT);
        return $this->stmtDeleteProduct->execute();
    }


    // Metodi privati
    private function createProduct(array $rs): Product{
        $product = new ProductProxy($this->dataLayer);
        $product->setId($rs["ID_PRODOTTO"]);
        $product->setName(($rs["NOME_PRODOTTO"]));
        $product->setPrice($rs["PREZZO_PRODOTTO"]);
        $product->setSexId($rs["ID_SESSO"]);
        $product->setCategoryId($rs["ID_CATEGORIA"]);
        $product->setProductorId($rs["ID_PRODUTTORE"]);
        $product->setDescription($rs["DESCRIZIONE_PRODOTTO"]);
        $product->setCopertina($rs["COPERTINA_PRODOTTO"]);
        return $product;


    }





}

?>
