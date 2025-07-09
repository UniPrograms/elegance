<?php

require_once("User.php");
require_once("Delivery.php");
require_once("Payment.php");


class Order {
    protected ?int $id;
    protected ?string $orderDate;
    protected ?string $deliveryDate;
    protected ?float $price;
    protected ?Address $address;
    protected ?string $status;
    protected ?User $user;
    protected ?Payment $payment;
    protected ?Delivery $delivery;
    protected ?array $orderItem;

    public function __construct() {
        $this->id = null;
        $this->orderDate = "";
        $this->deliveryDate = "";
        $this->price = 0.00;
        $this->address = null;
        $this->status = "";
        $this->user = null;
        $this->payment = null;
        $this->delivery = null;
        $this->orderItem = null;
    }

    // Getter
    public function getId(): ?int { return $this->id; }
    public function getOrderDate(): ?string { return $this->orderDate; }
    public function getDeliveryDate(): string { return $this->deliveryDate; }
    public function getPrice(): ?float { return $this->price; }
    public function getAddress(): ?Address { return $this->address; }
    public function getStatus(): ?string { return $this->status; }
    public function getUser(): ?User { return $this->user; }
    public function getPayment(): ?Payment { return $this->payment; }
    public function getDelivery(): ?Delivery { return $this->delivery; }
    public function getOrderItem(): ?array { return $this->orderItem; }

    // Setter
    public function setId(?int $id): void { $this->id = $id; }
    public function setOrderDate(?string $orderDate): void { $this->orderDate = $orderDate; }
    public function setDeliveryDate(?string $deliveryDate): void { $this->deliveryDate = $deliveryDate; }
    public function setPrice(?float $price): void { $this->price = $price; }
    public function setAddress(?Address $address): void { $this->address = $address; }
    public function setStatus(?string $status): void { $this->status = $status; }
    public function setUser(?User $user): void { $this->user = $user; }
    public function setPayment(?Payment $payment): void { $this->payment = $payment; }
    public function setDelivery(?Delivery $delivery): void { $this->delivery = $delivery; }
    public function setOrderitem(?array $orderItem): void { $this->orderItem = $orderItem; }
}
