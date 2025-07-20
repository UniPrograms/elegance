<?php


require_once("include/model/Image.php");


class ImageProxy extends Image{
    
    private ?DataLayer $dataLayer;
    private ?int $productId;

    public function __construct(?DataLayer $dataLayer){
        parent::__construct();
        $this->dataLayer = $dataLayer;
    }

    public function getProductId(): ?int { return $this->productId; }
    public function setProductId(int $productId): void { $this->productId = $productId; }


    //Override Getter
    public function getProduct(): ?Product{
        if(parent::getProduct() == null && $this->productId > 0){
            parent::setProduct((($this->dataLayer)->getProductDAO())->getProductById($this->productId));
        }
        return parent::getProduct();
    }
}