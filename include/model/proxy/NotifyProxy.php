<?php

require_once("include/model/Notify.php");

class NotifyProxy extends Notify{


    private ?DataLayer $dataLayer;
    

    private int $userId;

    public function __construct(?DataLayer $dataLayer){
        parent::__construct();
        $this->dataLayer = $dataLayer;
    }



    // Setter and Getter
    public function getuserId(): int {return $this->userId;}

    public function setUserId(int $userId): void {$this->userId = $userId;}



    //Override Getter

    public function getUser(): ?user{
        if(parent::getUser() == null && $this->userId > 0){
            parent::setUser((($this->dataLayer)->getUserDAO())->getuserById($this->userId));
        }
        return parent::getUser();
    }
}
