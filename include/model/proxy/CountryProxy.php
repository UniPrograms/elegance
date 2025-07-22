<?php


require_once("include/model/Country.php");


class CountryProxy extends Country{
    
    private ?DataLayer $dataLayer;

    public function __construct(?DataLayer $dataLayer){
        parent::__construct();
        $this->dataLayer = $dataLayer;
    }


}