<?php

require_once('include/model/Feature.php');

class FeatureProxy extends Feature{

    private ?DataLayer $dataLayer;

    public function __construct(?DataLayer $dataLayer){
        parent::__construct();
        $this->dataLayer = $dataLayer;
    }

}