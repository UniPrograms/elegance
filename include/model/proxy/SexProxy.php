<?php

require_once('include/model/Sex.php');

class SexProxy extends Sex{

    private ?DataLayer $dataLayer;

    public function __construct(?DataLayer $dataLayer){
        parent::__construct();
        $this->dataLayer = $dataLayer;
    }

    

}