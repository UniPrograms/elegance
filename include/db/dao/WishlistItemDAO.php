<?php

require_once("include/model/proxy/WishlistItemProxy.php");


class WishlistItemDAO extends DAO{


    private PDOStatement $stmtGetWishlistItemById;
    private PDOStatement $stmtGetAllWishlistItems;
    private PDOStatement $stmtGetWishlistItemByWishlist;
    private PDOStatement $stmtArticleIsContained;
    private PDOStatement $stmtProductIsContained;
    private PDOStatement $stmtInsertItem;
    private PDOStatement $stmtDeleteItem;



    // Costruttore
    public function __construct(?DataLayer $dataLayer) {
        parent::__construct($dataLayer);
        $this->init();
    }


    // Inizializzazione degli statement
    public function init(): void {
        $this->stmtGetWishlistItemById = $this->conn->prepare("SELECT * FROM ITEM_LISTA_DESIDERI WHERE ID = ?;");
        $this->stmtGetAllWishlistItems = $this->conn->prepare("SELECT * FROM ITEM_LISTA_DESIDERI;");
        $this->stmtGetWishlistItemByWishlist = $this->conn->prepare("SELECT * FROM ITEM_LISTA_DESIDERI WHERE ID_LISTA_DESIDERI = ?;");
        $this->stmtArticleIsContained = $this->conn->prepare("SELECT * FROM ITEM_LISTA_DESIDERI WHERE ID_LISTA_DESIDERI = ? AND ID_ARTICOLO = ?;");
        $this->stmtArticleIsContained = $this->conn->prepare("SELECT * FROM LISTA_DESIDERI_COMPLETA WHERE ID_LISTA_DESIDERI = ? AND ID_PRODOTTO = ?;");
        $this->stmtInsertItem = $this->conn->prepare("INSERT INTO ITEM_LISTA_DESIDERI (ID_LISTA_DESIDERI, ID_ARTICOLO) VALUES(?,?);");
        $this->stmtDeleteItem = $this->conn->prepare("DELETE FROM ITEM_LISTA_DESIDERI WHERE ID = ?");
    }


    // Statemetn

    /**
     * 
     * 
     * 
     * 
     * 
     */
    public function getWishlistItemById(int $id){
        $this->stmtGetWishlistItemById->bindValue(1, $id, PDO::PARAM_INT);
        $this->stmtGetWishlistItemById->execute();

        $rs = $this->stmtGetWishlistItemById->fetch(PDO::FETCH_ASSOC);

        return $rs ? $this->createWishlistItem($rs) : null;
    }
    /**
     * 
     * 
     * 
     * 
     * 
     */
    public function getAllWishlistItems(): array {
        $this->stmtGetAllWishlistItems->execute();
        $result = [];

        while ($rs = $this->stmtGetAllWishlistItems->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $this->createWishlistItem($rs);
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
    public function getWishlistItemByWishlist(Wishlist $wishlist): array{
        $this->stmtGetWishlistItemByWishlist->bindValue(1, $wishlist->getId(), PDO::PARAM_INT);
        $this->stmtGetWishlistItemByWishlist->execute();

        $result = [];
        while ($rs = $this->stmtGetWishlistItemByWishlist->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $this->createWishlistItem($rs);
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
    public function articleIsContainted(?int $article_id, ?int $wishlist_id): bool{
        $this->stmtArticleIsContained->bindValue(1, $wishlist_id, PDO::PARAM_INT);
        $this->stmtArticleIsContained->bindValue(2, $article_id, PDO::PARAM_INT);
        $this->stmtArticleIsContained->execute();

        $rs = $this->stmtArticleIsContained->fetch(PDO::FETCH_ASSOC);

        return $rs !== false; // true se trovato, false altrimenti
    }
        /**
     * 
     * 
     * 
     * 
     * 
     */
    public function productIsContainted(?int $product_id, ?int $wishlist_id): bool{
        $this->stmtProductIsContained->bindValue(1, $wishlist_id, PDO::PARAM_INT);
        $this->stmtProductIsContained->bindValue(2, $product_id, PDO::PARAM_INT);
        $this->stmtProductIsContained->execute();

        $rs = $this->stmtProductIsContained->fetch(PDO::FETCH_ASSOC);

        return $rs !== false; // true se trovato, false altrimenti
    }
    /**
     * 
     * 
     * 
     * 
     * 
     */
    public function storeItem(WishlistItem $item): ?WishlistItem{
        $this->stmtInsertItem->bindValue(1, $item->getWishlist()->getId(), PDO::PARAM_INT);
        $this->stmtInsertItem->bindValue(2, $item->getArticle()->getId(), PDO::PARAM_INT);

        if($this->stmtInsertItem->execute()){
                $item->setId($this->conn->lastInsertId());
                return $item;
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
    public function deleteItem(WishlistItem $item): bool{
        $this->stmtDeleteItem->bindValue(1, $item->getId(), PDO::PARAM_INT);
        return  $this->stmtDeleteItem->execute();
    }
    /**
     * 
     * 
     * 
     * 
     * 
     */
    public function deleteItemById(int $id): bool{
        $this->stmtDeleteItem->bindValue(1, $id, PDO::PARAM_INT);
        return  $this->stmtDeleteItem->execute();
    }



    // Metodi privati

    private function createWishlistItem(array $rs): WishlistItem {
        $WishlistItem = new WishlistItemProxy($this->dataLayer);
        $WishlistItem->setId($rs['ID']);
        $WishlistItem->setArticleId($rs["ID_ARTICOLO"]);
        $WishlistItem->setWishlistId($rs["ID_LISTA_DESIDERI"]);
        return $WishlistItem;
    }



}

?>
