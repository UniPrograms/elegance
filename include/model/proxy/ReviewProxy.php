<?php

require_once("include/model/Review.php");

class ReviewProxy extends Review{


    private ?DataLayer $dataLayer;
    

    private int $productId;
    private int $userId;

    public function __construct(?DataLayer $dataLayer){
        parent::__construct();
        $this->dataLayer = $dataLayer;
    }



    // Setter and Getter
    public function getProductId(): int {return $this->productId;}
    public function getUserId(): int {return $this->userId;}

    public function setProductId(int $productId): void {$this->productId = $productId;}
    public function setUserId(int $userId): void {$this->userId = $userId;}



    //Override Getter

    public function getProduct(): ?Product{
        if(parent::getProduct() == null && $this->productId > 0){
            parent::setProduct((($this->dataLayer)->getProductDAO())->getProductById($this->productId));
        }
        return parent::getProduct();
    }

    public function getUser(): ?User{
        if(parent::getUser() == null && $this->userId > 0){
            parent::setUser((($this->dataLayer)->getUserDAO())->getUserById($this->userId));
        }
        return parent::getUser();
    }


}
