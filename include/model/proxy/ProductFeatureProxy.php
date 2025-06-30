<?php

require_once("include/model/ProductFeature.php");

class ProductFeatureProxy extends ProductFeature{


    private ?DataLayer $dataLayer;
    
    private int $featureId;

    public function __construct(?DataLayer $dataLayer){
        parent::__construct();
        $this->dataLayer = $dataLayer;
    }



    // Setter and Getter
    public function getFeatureId(): int {return $this->featureId;}

    public function setFeatureId(int $featureId): void {$this->featureId = $featureId;}



    //Override Getter
    public function getFeature(): ?Feature{
        if(parent::getFeature() == null && $this->featureId > 0){
            parent::setFeature((($this->dataLayer)->getFeatureDAO())->getFeatureById($this->featureId));
        }
        return parent::getFeature();
    }

}
