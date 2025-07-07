<?php

require_once("include/model/Address.php");


class AddressProxy extends Address{

    private ?DataLayer $dataLayer;

    public function __construct(?DataLayer $dataLayer){
        parent::__construct();
        $this->dataLayer = $dataLayer;
    }




}
