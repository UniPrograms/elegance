<?php

require_once("include/model/CartItem.php");

class CartItemProxy extends CartItem{


    private ?DataLayer $dataLayer;
    private int $articleId;
    private int $cartId;

    public function __construct(?DataLayer $dataLayer){
        parent::__construct();
        $this->dataLayer = $dataLayer;
    }



    // Setter and Getter
    public function getArticleId(): int {return $this->articleId;}
    public function getCardId(): int {return $this->cartId;}

    public function setArticleId(int $articleId): void {$this->articleId = $articleId;}
    public function setCartId(int $cartId): void {$this->cartId = $cartId;}

    //Override Getter
    public function getArticle(): ?Article{
        if(parent::getArticle() == null && $this->articleId > 0){
            parent::setArticle((($this->dataLayer)->getArticleDAO())->getArticleById($this->articleId));
        }
        return parent::getArticle();
    }

    public function getCart(): ?Cart{
        if(parent::getCart() == null && $this->cartId > 0){
            parent::setCart((($this->dataLayer)->getCartDAO())->getCartById($this->cartId));
        }
        return parent::getCart();
    }

}
