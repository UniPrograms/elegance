<?php

require_once("include/model/Cart.php");

class CartProxy extends Cart{


    private ?DataLayer $dataLayer;
    private int $userId;

    public function __construct(?DataLayer $dataLayer){
        parent::__construct();
        $this->dataLayer = $dataLayer;
    }



    // Setter and Getter
    public function getUserId(): int {return $this->userId;}

    public function setUserId(int $userId): void {$this->userId = $userId;}


    //Override Getter
    public function getCartItem(): ?array{
        if(parent::getCartItem() == null && $this->id > 0){
            parent::setCartItem((($this->dataLayer)->getCartItemDAO())->getCartItemByCart($this));
        }
        return parent::getCartItem();
    }

}
