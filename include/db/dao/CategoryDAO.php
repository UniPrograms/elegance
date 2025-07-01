<?php

require_once("include/model/proxy/CategoryProxy.php");


class CategoryDAO extends DAO{


    private PDOStatement $stmtGetCategoryById;
    private PDOStatement $stmtGetAllCategories;
    private PDOStatement $stmtGetCategoryByName;
    private PDOStatement $stmtInsertCategory;
    private PDOStatement $stmtUpdateCategory;
    private PDOStatement $stmtDeleteCategory;


    // Costruttore
    public function __construct(?DataLayer $dataLayer) {
    parent::__construct($dataLayer);
    $this->init();
}



    // Inizializzazione degli statement
    public function init(): void {
        $this->stmtGetCategoryById = $this->conn->prepare("SELECT * FROM CATEGORIA WHERE ID = ?;");
        $this->stmtGetAllCategories = $this->conn->prepare("SELECT * FROM CATEGORIA;");
        $this->stmtGetCategoryByName = $this->conn->prepare("SELECT * FROM CATEGORIA WHERE NAME LIKE ?;");
        $this->stmtInsertCategory = $this->conn->prepare("INSERT INTO CATEGORIA (NOME) VALUES (?);");
        $this->stmtUpdateCategory = $this->conn->prepare("UPDATE CATEGORIA SET NOME = ? WHERE ID = ?;");
        $this->stmtDeleteCategory = $this->conn->prepare("DELETE FROM CATEGORIA WHERE ID = ?;");
    }


    // Statemetn

    /**
     * 
     * 
     * 
     * 
     * 
     */
    public function getCategoryById(int $id){
        $this->stmtGetCategoryById->bindValue(1, $id, PDO::PARAM_INT);
        $this->stmtGetCategoryById->execute();

        $rs = $this->stmtGetCategoryById->fetch(PDO::FETCH_ASSOC);

        return $rs ? $this->createCategory($rs) : null;
    }
    /**
     * 
     * 
     * 
     * 
     * 
     */
    public function getAllCategories(): array {
        $this->stmtGetAllCategories->execute();
        $result = [];

        while ($rs = $this->stmtGetAllCategories->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $this->createCategory($rs);
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
    public function getCategoryByName(string $name): ?Category {
        $this->stmtGetCategoryByName->bindValue(1, '%'.$name.'%', PDO::PARAM_STR);
        $this->stmtGetCategoryByName->execute();
        $rs = $this->stmtGetCategoryByName->fetch(PDO::FETCH_ASSOC);

        return $rs ? $this->createCategory($rs) : null;
    }
    /**
     * 
     * 
     * 
     * 
     * 
     */
    public function storeCategory(Category $category): bool {
        if ($category->getId() !== null) { 
            $this->stmtUpdateCategory->bindValue(1, $category->getName(), PDO::PARAM_STR);
            $this->stmtUpdateCategory->bindValue(5, $category->getId(), PDO::PARAM_INT);
            
            return $this->stmtUpdateCategory->execute();
        } else { 
            $this->stmtInsertCategory->bindValue(1, $category->getName(), PDO::PARAM_STR);

            return $this->stmtInsertCategory->execute();
        }
    }
    /**
     * 
     * 
     * 
     * 
     * 
     */
    public function deleteCategory(Category $category): bool {
        $this->stmtDeleteCategory->bindValue(1, $category->getId(), PDO::PARAM_INT);
        return $this->stmtDeleteCategory->execute();
    }



    // Metodi privati

    private function createCategory(array $rs): Category {
        $category = new CategoryProxy($this->dataLayer);
        $category->setId($rs['ID']);
        $category->setName($rs['NOME']);
        return $category;
    }



}

?>
