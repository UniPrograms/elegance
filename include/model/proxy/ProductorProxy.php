<?php


require_once("include/model/Productor.php");

class ProductorProxy extends Productor{

    private ?DataLayer $dataLayer;

    public function __construct(?DataLayer $dataLayer){
        parent::__construct();
        $this->dataLayer = $dataLayer;
    }



}



