<?php


require_once("include/model/Image.php");


class ImageProxy extends Image{
    
    private ?DataLayer $dataLayer;

    public function __construct(?DataLayer $dataLayer){
        parent::__construct();
        $this->dataLayer = $dataLayer;
    }


}