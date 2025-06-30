<?php

require_once("include/model/User.php");


class UserProxy extends User{

    private ?DataLayer $dataLayer;

    public function __construct(?DataLayer $dataLayer){
        parent::__construct();
        $this->dataLayer = $dataLayer;
    }




}
