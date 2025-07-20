<?php

require_once("include/model/proxy/ImageProxy.php");

class ImageDAO extends DAO{

    private PDOStatement $stmtGetImageById;
    private PDOStatement $stmtGetAllImage;
    private PDOStatement $stmtGetImageByProduct;
    private PDOStatement $stmtInsertImage;
    private PDOStatement $stmtUpdateImage;
    private PDOStatement $stmtDeleteImage;

    // Costruttore
    public function __construct(?DataLayer $dataLayer) {
        parent::__construct($dataLayer);
        $this->init();
    }


    // Inizializzazione degli statement
    public function init(): void {
        $this->stmtGetImageById = $this->conn->prepare("SELECT * FROM IMMAGINE_COMPLETA WHERE ID = ?;");
        $this->stmtGetAllImage = $this->conn->prepare("SELECT * FROM IMMAGINE_COMPLETA;");
        $this->stmtGetImageByProduct = $this->conn->prepare("SELECT * FROM IMMAGINE_COMPLETA WHERE ID_PRODOTTO = ?;");
        $this->stmtInsertImage = $this->conn->prepare("INSERT INTO IMMAGINE(PATH, ID_PRODOTTO) VALUES (?,?);");
        $this->stmtUpdateImage = $this->conn->prepare("UPDATE IMMAGINE SET PATH = ?, ID_PRODOTTO = ? WHERE ID = ?;");
        $this->stmtDeleteImage = $this->conn->prepare("DELETE FROM IMMAGINE WHERE ID = ?;");
    }


    // Statemetn

    /**
     * 
     * 
     * 
     * 
     * 
     */
    public function getImageById(int $id): ?Image{
        $this->stmtGetImageById->bindValue(1, $id, PDO::PARAM_INT);
        $this->stmtGetImageById->execute();

        $rs = $this->stmtGetImageById->fetch(PDO::FETCH_ASSOC);

        return $rs ? $this->createImage($rs) : null;
    }
    /**
     * 
     * 
     * 
     * 
     * 
     */
    public function getAllImage(): array {
        $this->stmtGetAllImage->execute();
        $result = [];

        while ($rs = $this->stmtGetAllImage->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $this->createImage($rs);
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
    public function getAllImagesByProduct(Product $product): array {
        $this->stmtGetImageByProduct->bindValue(1, $product->getId(), PDO::PARAM_STR);
        $this->stmtGetImageByProduct->execute();
        $result = [];

        while ($rs = $this->stmtGetImageByProduct->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $this->createImage($rs);
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
    public function storeImage(Image $image, Product $product): ?Image {
        if ($image->getId() !== null) { // Aggiorno la categoria
            $this->stmtUpdateImage->bindValue(1, $image->getPath(), PDO::PARAM_STR);
            $this->stmtUpdateImage->bindValue(2, $product->getId(), PDO::PARAM_INT);
            $this->stmtUpdateImage->bindValue(3, $image->getId(), PDO::PARAM_INT);
            
            if($this->stmtUpdateImage->execute()){
                return $image;
            }
        } else {   // Inserisco la categoria
            $this->stmtInsertImage->bindValue(1, $image->getPath(), PDO::PARAM_STR);
            $this->stmtInsertImage->bindValue(2, $product->getId(), PDO::PARAM_INT);
            if($this->stmtInsertImage->execute()){
                return $this->getImageById($this->conn->lastInsertId());
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
    public function deleteImage(Image $Image): bool {
        $this->stmtDeleteImage->bindValue(1, $Image->getId(), PDO::PARAM_INT);
        return $this->stmtDeleteImage->execute();
    }
    /**
     * 
     * 
     * 
     * 
     * 
     */
    public function deleteImageById(int $id): bool {
        $this->stmtDeleteImage->bindValue(1, $id, PDO::PARAM_INT);
        return $this->stmtDeleteImage->execute();
    }



    // Metodi privati

    private function createImage(array $rs): Image {
        $image = new ImageProxy($this->dataLayer);
        $image->setId($rs['ID']);
        $image->setPath($rs['PATH']);
        $image->setProductId($rs["ID_PRODOTTO"]);
        return $image;
    }



}

?>
