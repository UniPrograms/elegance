<?php

require_once("include/model/proxy/CartItemProxy.php");


class CartItemDAO extends DAO {

    private PDOStatement $stmtGetCartItemById;
    private PDOStatement $stmtGetAllCartItems;
    private PDOStatement $stmtGetCartItemByCart;
    private PDOStatement $stmtInsertItem;
    private PDOStatement $stmtDeleteItem;



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
        $this->stmtInsertItem = $this->conn->prepare("INSERT INTO ITEM_CARRELLO (ID_CARRELLO, ID_ARTICOLO) VALUES(?,?);");
        $this->stmtDeleteItem = $this->conn->prepare("DELETE FROM ITEM_CARRELLO WHERE ID = ?");
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
    /**
     * 
     * 
     * 
     * 
     * 
     */
    public function storeItem(CartItem $item): ?CartItem{
        $this->stmtInsertItem->bindValue(1, $item->getCart()->getId(), PDO::PARAM_INT);
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
    public function deleteItem(CartItem $item): bool{
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

    private function createCartItem(array $rs): CartItem {
        $cartItem = new CartItemProxy($this->dataLayer);
        $cartItem->setId($rs['ID']);
        $cartItem->setArticleId($rs["ID_ARTICOLO"]);
        $cartItem->setCartId($rs["ID_CARRELLO"]);
        return $cartItem;
    }



}

?>
