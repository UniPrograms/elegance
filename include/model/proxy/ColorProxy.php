<?php


require_once("include/model/Color.php");


class ColorProxy extends Color{
    
    private ?DataLayer $dataLayer;

    public function __construct(?DataLayer $dataLayer){
        parent::__construct();
        $this->dataLayer = $dataLayer;
    }


}