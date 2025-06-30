<?php

require_once("include/model/Article.php");

class ArticleProxy extends Article{


    private ?DataLayer $dataLayer;
    

    private int $productId;
    private int $sizeId;
    private int $colorId;

    public function __construct(?DataLayer $dataLayer){
        parent::__construct();
        $this->dataLayer = $dataLayer;
    }



    // Setter and Getter
    public function getProductId(): int {return $this->productId;}
    public function getSizeId(): int {return $this->sizeId;}
    public function getColorId(): int {return $this->colorId;}

    public function setProductId(int $productId): void {$this->productId = $productId;}
    public function setSizeId(int $sizeId): void {$this->sizeId = $sizeId;}
    public function setColorId(int $colorId): void {$this->colorId = $colorId;}



    //Override Getter

    public function getProduct(): ?Product{
        if(parent::getProduct() == null && $this->productId > 0){
            parent::setProduct((($this->dataLayer)->getProductDAO())->getProductById($this->productId));
        }
        return parent::getProduct();
    }

    public function getSize(): ?Size{
        if(parent::getSize() == null && $this->sizeId > 0){
            parent::setSize((($this->dataLayer)->getSizeDAO())->getSizeById($this->sizeId));
        }
        return parent::getSize();
    }

    public function getColor(): ?Color{
        if(parent::getColor() == null && $this->colorId > 0){
            parent::setColor((($this->dataLayer)->getColorDAO())->getColorById($this->colorId));
        }
        return parent::getColor();
    }
}
