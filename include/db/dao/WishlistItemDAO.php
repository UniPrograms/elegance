<?php

require_once("include/model/proxy/WishlistItemProxy.php");


class WishlistItemDAO extends DAO{


    private PDOStatement $stmtGetWishlistItemById;
    private PDOStatement $stmtGetAllWishlistItems;
    private PDOStatement $stmtGetWishlistItemByWishlist;



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


    // Metodi privati

    private function createWishlistItem(array $rs): WishlistItem {
        $WishlistItem = new WishlistItemProxy($this->dataLayer);
        $WishlistItem->setId($rs['ID']);
        $WishlistItem->setArticleId($rs["ID_ARTICOLO"]);
        return $WishlistItem;
    }



}

?>
