<?php

require_once("include/model/proxy/CartItemProxy.php");


class CartItemDAO extends DAO {

    private PDOStatement $stmtGetCartItemById;
    private PDOStatement $stmtGetAllCartItems;
    private PDOStatement $stmtGetCartItemByCart;



    // Costruttore
    public function __construct(?DataLayer $dataLayer) {
        parent::__construct($dataLayer);
        $this->init();
    }



    // Inizializzazione degli statement
    public function init(): void {
        $this->stmtGetCartItemById = $this->conn->prepare("SELECT * FROM ITEM_CARRELLO WHERE ID = ?;");
        $this->stmtGetAllCartItems = $this->conn->prepare("SELECT * FROM ITEM_CARRELLO;");
        $this->stmtGetCartItemByCart = $this->conn->prepare("SELECT * FROM ITEM_CARRELLO WHERE ID_CARRELLO = ?;");
    }


    // Statemetn

    /**
     * 
     * 
     * 
     * 
     * 
     */
    public function getCartItemById(int $id){
        $this->stmtGetCartItemById->bindValue(1, $id, PDO::PARAM_INT);
        $this->stmtGetCartItemById->execute();

        $rs = $this->stmtGetCartItemById->fetch(PDO::FETCH_ASSOC);

        return $rs ? $this->createCartItem($rs) : null;
    }
    /**
     * 
     * 
     * 
     * 
     * 
     */
    public function getAllCartItems(): array {
        $this->stmtGetAllCartItems->execute();
        $result = [];

        while ($rs = $this->stmtGetAllCartItems->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $this->createCartItem($rs);
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
    public function getCartItemByCart(Cart $cart): array{
        $this->stmtGetCartItemByCart->bindValue(1, $cart->getId(), PDO::PARAM_INT);
        $this->stmtGetCartItemByCart->execute();
        
        $result = [];
        while ($rs = $this->stmtGetCartItemByCart->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $this->createCartItem($rs);
        }
        return $result;
    }


    // Metodi privati

    private function createCartItem(array $rs): CartItem {
        $cartItem = new CartItemProxy($this->dataLayer);
        $cartItem->setId($rs['ID']);
        $cartItem->setArticleId($rs["ID_ARTICOLO"]);
        return $cartItem;
    }



}

?>
