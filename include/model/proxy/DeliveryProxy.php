<?php

require_once('include/model/Delivery.php');

class DeliveryProxy extends Delivery{

    private ?DataLayer $dataLayer;

    public function __construct(?DataLayer $dataLayer){
        parent::__construct();
        $this->dataLayer = $dataLayer;
    }

}