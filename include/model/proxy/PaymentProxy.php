<?php

require_once("include/model/Payment.php");

class PaymentProxy extends Payment{

    private ?DataLayer $dataLayer;

    public function __construct(?DataLayer $dataLayer){
        parent::__construct();
        $this->dataLayer = $dataLayer;
    }


}





