<?php

require_once("include/model/proxy/CartProxy.php");


class CartDAO extends DAO{

    

    private PDOStatement $stmtGetCartById;
    private PDOStatement $stmtGetAllCarts;
    private PDOStatement $stmtGetCartByUser;


    // Costruttore
    public function __construct(?DataLayer $dataLayer) {
        parent::__construct($dataLayer);
        $this->init();
    }



    // Inizializzazione degli statement
    public function init(): void {
        $this->stmtGetCartById = $this->conn->prepare("SELECT * FROM CARRELLO WHERE ID = ?;");
        $this->stmtGetAllCarts = $this->conn->prepare("SELECT * FROM CARRELLO;");
        $this->stmtGetCartByUser = $this->conn->prepare("SELECT * FROM CARRELLO WHERE ID_UTENTE = ?;");
    }


    // Statemetn

    /**
     * 
     * 
     * 
     * 
     * 
     */
    public function getCartById(int $id){
        $this->stmtGetCartById->bindValue(1, $id, PDO::PARAM_INT);
        $this->stmtGetCartById->execute();

        $rs = $this->stmtGetCartById->fetch(PDO::FETCH_ASSOC);

        return $rs ? $this->createCart($rs) : null;
    }
    /**
     * 
     * 
     * 
     * 
     * 
     */
    public function getAllCarts(): array {
        $this->stmtGetAllCarts->execute();
        $result = [];

        while ($rs = $this->stmtGetAllCarts->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $this->createCart($rs);
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
    public function getCartByUser(User $user): ?Cart {
        $this->stmtGetCartByUser->bindValue(1, $user->getId(), PDO::PARAM_INT);
        $this->stmtGetCartByUser->execute();

        $rs = $this->stmtGetCartByUser->fetch(PDO::FETCH_ASSOC);

        return $rs ? $this->createCart($rs) : null;
    }
    /**
     * 
     * 
     * 
     * 
     * 
     */
    public function getCartByUserId(int $id): ?Cart {
        $this->stmtGetCartByUser->bindValue(1, $id, PDO::PARAM_INT);
        $this->stmtGetCartByUser->execute();

        $rs = $this->stmtGetCartByUser->fetch(PDO::FETCH_ASSOC);

        return $rs ? $this->createCart($rs) : null;
    }


    // Metodi privati
    private function createCart(array $rs): Cart {
        $cart = new CartProxy($this->dataLayer);
        $cart->setId($rs['ID']);
        $cart->setUserId($rs["ID_UTENTE"]);
        return $cart;
    }



}

?>
