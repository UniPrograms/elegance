<?php

require_once("include/model/Product.php");

class ProductProxy extends Product{


    private ?DataLayer $dataLayer;
    

    private int $productorId;
    private int $categoryId;
    private int $sexId;

    public function __construct(?DataLayer $dataLayer){
        parent::__construct();
        $this->dataLayer = $dataLayer;
    }



    // Setter and Getter
    public function getProductorId(): int {return $this->productorId;}
    public function getCategoryId(): int {return $this->categoryId;}
    public function getSexId(): int {return $this->sexId;}

    public function setProductorId(int $productorId): void {$this->productorId = $productorId;}
    public function setCategoryId(int $categoryId): void {$this->categoryId = $categoryId;}
    public function setSexId(int $sexId): void {$this->sexId = $sexId;}



    //Override Getter

    public function getProductor(): ?Productor{
        if(parent::getProductor() == null && $this->productorId > 0){
            parent::setProductor((($this->dataLayer)->getProductorDAO())->getProductorById($this->productorId));
        }
        return parent::getProductor();
    }

    public function getCategory(): ?Category{
        if(parent::getCategory() == null && $this->categoryId > 0){
            parent::setCategory((($this->dataLayer)->getCategoryDAO())->getCategoryById($this->categoryId));
        }
        return parent::getCategory();
    }

    public function getSex(): ?Sex{
        if(parent::getSex() == null && $this->sexId > 0){
            parent::setSex((($this->dataLayer)->getSexDAO())->getSexById($this->sexId));
        }
        return parent::getSex();
    }

    public function getImages(): ?array{
        if(parent::getImages() == null && $this->id > 0){
            parent::setImages((($this->dataLayer)->getImageDAO())->getImageByProduct($this));
        }
        return parent::getImages();
    }

    public function getFeatures(): ?array{
        if(parent::getFeatures() == null && $this->id > 0){
            parent::setFeatures((($this->dataLayer)->getProductFeatureDAO())->getProductFeaturesByProduct($this));
        }
        return parent::getFeatures();
    }


}
