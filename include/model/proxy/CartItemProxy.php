<?php

require_once("include/model/CartItem.php");

class CartItemProxy extends CartItem{


    private ?DataLayer $dataLayer;
    private int $articleId;

    public function __construct(?DataLayer $dataLayer){
        parent::__construct();
        $this->dataLayer = $dataLayer;
    }



    // Setter and Getter
    public function getArticleId(): int {return $this->articleId;}

    public function setArticleId(int $articleId): void {$this->articleId = $articleId;}


    //Override Getter
    public function getArticle(): ?Article{
        if(parent::getArticle() == null && $this->articleId > 0){
            parent::setArticle((($this->dataLayer)->getArticleDAO())->getArticleById($this->articleId));
        }
        return parent::getArticle();
    }

}
