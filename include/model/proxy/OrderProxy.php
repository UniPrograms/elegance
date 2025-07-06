<?php

require_once('include/model/Order.php');

class OrderProxy extends Order{

    private ?DataLayer $dataLayer;
    private int $userId;
    private int $paymentId;
    private int $deliveryId;

    public function __construct(?DataLayer $dataLayer){
        parent::__construct();
        $this->dataLayer = $dataLayer;
    }


    // Getter and Setter

    public function getUserId(): int {return $this->userId;}
    public function getPaymentId(): int {return $this->paymentId;}
    public function getDeliveryId(): int {return $this->deliveryId;}

    public function setUserId(int $userId): void { $this->userId = $userId; }
    public function setPaymentId(int $paymentId): void { $this->paymentId = $paymentId; }
    public function setDeliveryId(int $deliveryId): void { $this->deliveryId = $deliveryId; }


    // Other Methods
    public function getUser(): ?User{
        if(parent::getUser() == null && $this->userId > 0){
            parent::setUser((($this->dataLayer)->getUserDAO())->getUserById($this->userId));
        }
        return parent::getUser();
    }


    public function getPayment(): ?Payment{
        if(parent::getPayment() == null && $this->paymentId > 0){
            parent::setPayment((($this->dataLayer)->getPaymentDAO())->getPaymentById($this->paymentId));
        }
        return parent::getPayment();
    }

    public function getDelivery(): ?Delivery{
        if(parent::getDelivery() == null && $this->deliveryId > 0){
            parent::setDelivery((($this->dataLayer)->getDeliveryDAO())->getDeliveryById($this->deliveryId));
        }
        return parent::getDelivery();
    }

    public function getOrderItem(): ?array{
        if(parent::getOrderItem() == null && $this->id > 0){
            parent::setOrderItem((($this->dataLayer)->getOrderItemDAO())->getOrderItemByOrder($this));
        }
        return parent::getOrderItem();
    }

}