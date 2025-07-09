<?php

require_once("include/model/OrderItem.php");

class OrderItemProxy extends OrderItem{


    private ?DataLayer $dataLayer;
    private int $articleId;
    private int $orderId;


    public function __construct(?DataLayer $dataLayer){
        parent::__construct();
        $this->dataLayer = $dataLayer;
    }



    // Setter and Getter
    public function getArticleId(): int {return $this->articleId;}
    public function getOrderId(): int {return $this->orderId;}

    public function setArticleId(int $articleId): void {$this->articleId = $articleId;}
    public function setOrderId(int $orderId): void {$this->orderId = $orderId;}


    //Override Getter
    public function getArticle(): ?Article{
        if(parent::getArticle() == null && $this->articleId > 0){
            parent::setArticle((($this->dataLayer)->getArticleDAO())->getArticleById($this->articleId));
        }
        return parent::getArticle();
    }


     public function getOrder(): ?Order{
        if(parent::getOrder() == null && $this->orderId > 0){
            parent::setOrder((($this->dataLayer)->getOrderDAO())->getOrderById($this->orderId));
        }
        return parent::getOrder();
    }


}
