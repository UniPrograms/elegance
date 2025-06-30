<?php

require_once("include/model/proxy/WishlistProxy.php");


class WishlistDAO extends DAO{

    private PDOStatement $stmtGetWishlistById;
    private PDOStatement $stmtGetAllWishlists;
    private PDOStatement $stmtGetWishlistByUser;



    // Costruttore
    public function __construct(?DataLayer $dataLayer) {
        parent::__construct($dataLayer);
        $this->init();
    }



    // Inizializzazione degli statement
    public function init(): void {
        $this->stmtGetWishlistById = $this->conn->prepare("SELECT * FROM LISTA_DESIDERI WHERE ID = ?;");
        $this->stmtGetAllWishlists = $this->conn->prepare("SELECT * FROM LISTA_DESIDERI;");
        $this->stmtGetWishlistByUser = $this->conn->prepare("SELECT * FROM LISTA_DESIDERI WHERE ID_UTENTE = ?;");
    }


    // Statemetn

    /**
     * 
     * 
     * 
     * 
     * 
     */
    public function getWishlistById(int $id){
        $this->stmtGetWishlistById->bindValue(1, $id, PDO::PARAM_INT);
        $this->stmtGetWishlistById->execute();

        $rs = $this->stmtGetWishlistById->fetch(PDO::FETCH_ASSOC);

        return $rs ? $this->createWishlist($rs) : null;
    }
    /**
     * 
     * 
     * 
     * 
     * 
     */
    public function getAllWishlists(): array {
        $this->stmtGetAllWishlists->execute();
        $result = [];

        while ($rs = $this->stmtGetAllWishlists->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $this->createWishlist($rs);
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
    public function getWishlistByUser(User $user): ?Wishlist {
        $this->stmtGetWishlistByUser->bindValue(1, $user->getId(), PDO::PARAM_INT);
        $this->stmtGetWishlistByUser->execute();

        $rs = $this->stmtGetWishlistByUser->fetch(PDO::FETCH_ASSOC);

        return $rs ? $this->createWishlist($rs) : null;
    }


    // Metodi privati

    private function createWishlist(array $rs): Wishlist {
        $wishlist = new WishlistProxy($this->dataLayer);
        $wishlist->setId($rs['ID']);
        $wishlist->setUserId($rs["ID_UTENTE"]);
        return $wishlist;
    }



}

?>
