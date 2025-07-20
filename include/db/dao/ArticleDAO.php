<?php

require_once("include/model/proxy/ArticleProxy.php");


class ArticleDAO extends DAO{



    private PDOStatement $stmtGetArticleById;
    private PDOStatement $stmtGetArticleByIdFullQuantity;
    private PDOStatement $stmtGetAllArticles;
    private PDOStatement $stmtGetAllArticlesFullQuantity;
    private PDOStatement $stmtGetAllArticleByProductId;
    private PDOStatement $stmtGetAllArticlesFullQuantityByProductId;
    private PDOStatement $stmtGetArticleByName;
    private PDOStatement $stmtGetArticleByNameInRange;
    private PDOStatement $stmtGetArticleByCategory;
    private PDOStatement $stmtGetArticleByCategoryInRange;
    private PDOStatement $stmtGetArticleByProductor;
    private PDOStatement $stmtGetArticleByProductorInRange;
    private PDOStatement $stmtGetArticleByProductSizeColor;
    private PDOStatement $stmtGetArticleTotalQuantity;
    private PDOStatement $stmtGetArticleQuantityInCarts;
    private PDOStatement $stmtInsertArticle;
    private PDOStatement $stmtUpdateArticle;
    private PDOStatement $stmtDeleteArticle;


    // Costruttore
    public function __construct(?DataLayer $dataLayer) {
        parent::__construct($dataLayer);
        $this->init();
    }


    // Inizializzazione degli Statement
    public function init(): void {
        $this->stmtGetArticleById = $this->conn->prepare("SELECT * FROM ARTICOLO_PRODOTTO_COMPLETO WHERE ID_ARTICOLO = ?;");
        $this->stmtGetArticleByIdFullQuantity = $this->conn->prepare("SELECT * FROM ARTICOLO_COMPLETO_FULL_QUANTITY WHERE ID_ARTICOLO = ?;");
        $this->stmtGetAllArticles = $this->conn->prepare("SELECT * FROM ARTICOLO_PRODOTTO_COMPLETO;");
        $this->stmtGetAllArticlesFullQuantity = $this->conn->prepare("SELECT * FROM ARTICOLO_PRODOTTO_COMPLETO_FULL_QUANTITY;");
        $this->stmtGetAllArticlesFullQuantityByProductId = $this->conn->prepare("SELECT ID_ARTICOLO FROM ARTICOLO_PRODOTTO_COMPLETO_FULL_QUANTITY WHERE ID_PRODOTTO = ?;");
        $this->stmtGetAllArticleByProductId = $this->conn->prepare("SELECT ID_ARTICOLO FROM ARTICOLO_PRODOTTO_COMPLETO WHERE ID_PRODOTTO = ?;");
        $this->stmtGetArticleByName = $this->conn->prepare("SELECT * FROM ARTICOLO_PRODOTTO_COMPLETO WHERE NOME_PRODOTTO LIKE ?;");
        $this->stmtGetArticleByNameInRange = $this->conn->prepare("SELECT * FROM ARTICOLO_PRODOTTO_COMPLETO WHERE NOME_PRODOTTO LIKE ? LIMIT ? OFFSET ?;");
        $this->stmtGetArticleByCategory = $this->conn->prepare("SELECT * FROM ARTICOLO_PRODOTTO_COMPLETO WHERE ID_CATEGORIA = ?;");
        $this->stmtGetArticleByCategoryInRange = $this->conn->prepare("SELECT * FROM ARTICOLO_PRODOTTO_COMPLETO WHERE ID_CATEGORIA = ? LIMIT ? OFFSET ?;");
        $this->stmtGetArticleByProductor = $this->conn->prepare("SELECT * FROM ARTICOLO_PRODOTTO_COMPLETO WHERE ID_PRODUTTORE = ?;");
        $this->stmtGetArticleByProductorInRange = $this->conn->prepare("SELECT * FROM ARTICOLO_PRODOTTO_COMPLETO WHERE ID_PRODUTTORE = ? LIMIT ? OFFSET ?;");
        $this->stmtGetArticleByProductSizeColor = $this->conn->prepare("SELECT * FROM ARTICOLO_PRODOTTO_COMPLETO WHERE ID_PRODOTTO = ? AND ID_TAGLIA = ? AND ID_COLORE = ?;");
        $this->stmtGetArticleTotalQuantity = $this->conn->prepare("SELECT SUM(QUANTITA) AS TOTAL FROM ARTICOLO_COMPLETO;");
        $this->stmtGetArticleQuantityInCarts = $this->conn->prepare("SELECT COUNT(*) AS TOTAL FROM ITEM_CARRELLO WHERE ID_ARTICOLO = ?;");
        $this->stmtInsertArticle = $this->conn->prepare("INSERT INTO ARTICOLO (ID_PRODOTTO, ID_TAGLIA, ID_COLORE, QUANTITA) VALUES (?, ?, ?, ?);");
        $this->stmtUpdateArticle = $this->conn->prepare("UPDATE ARTICOLO SET ID_PRODOTTO = ?, ID_TAGLIA = ?, ID_COLORE = ?, QUANTITA = ? WHERE ID = ?;");
        $this->stmtDeleteArticle = $this->conn->prepare("DELETE FROM ARTICOLO WHERE ID = ?;");

    }



    public function getArticleById(int $id): ?Article {
        $this->stmtGetArticleById->bindValue(1, $id, PDO::PARAM_INT);
        $this->stmtGetArticleById->execute();

        $rs = $this->stmtGetArticleById->fetch(PDO::FETCH_ASSOC);

        return $rs ? $this->createArticle($rs) : null;
    }
    /**
    * 
    * 
    * 
    * 
    * 
    */
    public function getArticleByIdFullQuantity(int $id): ?Article {
        $this->stmtGetArticleByIdFullQuantity->bindValue(1, $id, PDO::PARAM_INT);
        $this->stmtGetArticleByIdFullQuantity->execute();

        $rs = $this->stmtGetArticleByIdFullQuantity->fetch(PDO::FETCH_ASSOC);

        return $rs ? $this->createArticle($rs) : null;
    }
    /**
    * 
    * 
    * 
    * 
    * 
    */
    public function getAllArticle(): array{
        $this->stmtGetAllArticles->execute();
        $result = [];

        while ($rs = $this->stmtGetAllArticles->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $this->createArticle($rs);
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
    public function getAllArticleFullQuantity(): array{
        $this->stmtGetAllArticlesFullQuantity->execute();
        $result = [];

        while ($rs = $this->stmtGetAllArticlesFullQuantity->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $this->createArticle($rs);
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
    public function getAllArticleByProductId(int $id): array {
        $this->stmtGetAllArticleByProductId->bindValue(1, $id, PDO::PARAM_INT);
        $this->stmtGetAllArticleByProductId->execute();

        $result = [];
        while ($rs = $this->stmtGetAllArticleByProductId->fetch(PDO::FETCH_ASSOC)) {
            $article_id = $rs["ID_ARTICOLO"];
            if($article_id != null){
               $result[] = $this->getArticleById($rs["ID_ARTICOLO"]); 
            }
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
    public function getAllArticleByFullQuantityProductId(int $id): array {
        $this->stmtGetAllArticlesFullQuantityByProductId->bindValue(1, $id, PDO::PARAM_INT);
        $this->stmtGetAllArticlesFullQuantityByProductId->execute();

        $result = [];
        while ($rs = $this->stmtGetAllArticlesFullQuantityByProductId->fetch(PDO::FETCH_ASSOC)) {
            $article_id = $rs["ID_ARTICOLO"];
            if($article_id != null){
               $result[] = $this->getArticleByIdFullQuantity($rs["ID_ARTICOLO"]); 
            }
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
    public function getArticleByName(string $name, ?int $offset = null, ?int $limit = null): array {
        if($offset != null && $limit != null){
            $stmt = $this->stmtGetArticleByNameInRange;
            $stmt->bindValue(1, '%' . $name . '%', PDO::PARAM_STR);
            $stmt->bindValue(2, $limit, PDO::PARAM_INT);
            $stmt->bindValue(3, $offset, PDO::PARAM_INT);
        }
        else{
            // Usa la query senza paginazione
            $stmt = $this->stmtGetArticleByName;
            $stmt->bindValue(1, '%' . $name . '%', PDO::PARAM_STR);
        }
        $stmt->execute();
        $result = [];

        while ($rs = $this->stmtGetArticleByName->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $this->createArticle($rs);
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
    public function getArticleByCategory(Category $category, ?int $offset = null, ?int $limit = null): array {
        if ($limit !== null && $offset !== null) {
            $stmt = $this->stmtGetArticleByCategoryInRange;
            $stmt->bindValue(1, $category->getId(), PDO::PARAM_INT);
            $stmt->bindValue(2, $limit, PDO::PARAM_INT);
            $stmt->bindValue(3, $offset, PDO::PARAM_INT);
        } else {
            $stmt = $this->stmtGetArticleByCategory;
            $stmt->bindValue(1, $category->getId(), PDO::PARAM_INT);
        }
    
        $stmt->execute();
        $result = [];
    
        while ($rs = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $this->createArticle($rs);
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
    public function getArticleByProductor(Productor $Productor, ?int $offset = null, ?int $limit = null): array {
        if ($limit !== null && $offset !== null) {
            $stmt = $this->stmtGetArticleByProductorInRange;
            $stmt->bindValue(1, $Productor->getId(), PDO::PARAM_INT);
            $stmt->bindValue(2, $limit, PDO::PARAM_INT);
            $stmt->bindValue(3, $offset, PDO::PARAM_INT);
        } else {
            $stmt = $this->stmtGetArticleByProductor;
            $stmt->bindValue(1, $Productor->getId(), PDO::PARAM_INT);
        }
    
        $stmt->execute();
        $result = [];
    
        while ($rs = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $this->createArticle($rs);
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
    public function getArticleByProductSizeColor(int $product_id, int $size_id, int $color_id): ?Article {

        $this->stmtGetArticleByProductSizeColor->bindValue(1, $product_id, PDO::PARAM_INT);
        $this->stmtGetArticleByProductSizeColor->bindValue(2, $size_id, PDO::PARAM_INT);
        $this->stmtGetArticleByProductSizeColor->bindValue(3, $color_id, PDO::PARAM_INT);

        $this->stmtGetArticleByProductSizeColor->execute();

        $rs = $this->stmtGetArticleByProductSizeColor->fetch(PDO::FETCH_ASSOC);

        return $rs ? $this->createArticle($rs) : null;
       
    }
    /**
    * 
    * 
    * 
    * 
    * 
    */
    public function getArticleTotalQuantity(): ?int {

        $this->stmtGetArticleTotalQuantity->execute();

        $rs = $this->stmtGetArticleTotalQuantity->fetch(PDO::FETCH_ASSOC);

        return $rs["TOTAL"];
       
    }
    /**
    * 
    * 
    * 
    * 
    * 
    */
    public function getArticleQuantityInCarts(int $article_id): ?int {
        $this->stmtGetArticleQuantityInCarts->bindValue(1, $article_id, PDO::PARAM_INT);
        $this->stmtGetArticleQuantityInCarts->execute();

        $rs = $this->stmtGetArticleQuantityInCarts->fetch(PDO::FETCH_ASSOC);

        return $rs["TOTAL"];
       
    }
    /**
    * 
    * 
    * 
    * 
    * 
    */
    public function storeArticle(Article $article): ?Article {
        if ($article->getId() !== null) { // Aggiorno l'articolo
            $this->stmtUpdateArticle->bindValue(1, $article->getProduct()->getId(), PDO::PARAM_INT);
            $this->stmtUpdateArticle->bindValue(2, $article->getSize()->getId(), PDO::PARAM_INT);
            $this->stmtUpdateArticle->bindValue(3, $article->getColor()->getId(), PDO::PARAM_INT);
            $this->stmtUpdateArticle->bindValue(4, $article->getQuantity(), PDO::PARAM_INT);
            $this->stmtUpdateArticle->bindValue(5, $article->getId(), PDO::PARAM_INT);
            
            if($this->stmtUpdateArticle->execute()){
                return $article;
            }
        } else {   // Inserisco l'articolo
            $this->stmtInsertArticle->bindValue(1, $article->getProduct()->getId(), PDO::PARAM_INT);
            $this->stmtInsertArticle->bindValue(2, $article->getSize()->getId(), PDO::PARAM_INT);
            $this->stmtInsertArticle->bindValue(3, $article->getColor()->getId(), PDO::PARAM_INT);
            $this->stmtInsertArticle->bindValue(4, $article->getQuantity(), PDO::PARAM_INT);
            
            if($this->stmtInsertArticle->execute()){
                $article->setId($this->conn->lastInsertId());
                return $article;
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
    public function deleteArticle(Article $article): bool {
        $this->stmtDeleteArticle->bindValue(1, $article->getId(), PDO::PARAM_INT);
        return $this->stmtDeleteArticle->execute();
    }
    /**
    * 
    * 
    * 
    * 
    * 
    */
    public function deleteArticleById(int $id): bool {
        $this->stmtDeleteArticle->bindValue(1, $id, PDO::PARAM_INT);
        return $this->stmtDeleteArticle->execute();
    }

    // Metodi privati
    private function createArticle(array $rs): Article{
        $article = new ArticleProxy($this->dataLayer);
        $article->setId($rs["ID_ARTICOLO"]);
        $article->setProductId(($rs["ID_PRODOTTO"]));
        $article->setSizeId($rs["ID_TAGLIA"]);
        $article->setColorId($rs["ID_COLORE"]);
        $article->setQuantity($rs["QUANTITA"]);
        return $article;


    }






}

?>
