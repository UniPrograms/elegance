<?php


require_once("include/model/Size.php");


class SizeProxy extends Size{
    
    private ?DataLayer $dataLayer;

    public function __construct(?DataLayer $dataLayer){
        parent::__construct();
        $this->dataLayer = $dataLayer;
    }



}