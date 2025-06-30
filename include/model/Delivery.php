<?php

class Delivery{
    private ?int $id;
    private string $name;
    private float $price;


    public function __construct(){
        $this->id = null;
        $this->name = '';
        $this->price = 0.00;
    }

    // Getter
    public function getId(): ?int {return $this->id;}
    public function getName(): string {return $this->name;}
    public function getPrice(): float {return $this->price;}



    // Setter
    public function setId(?int $id) { $this->id = $id; }
    public function setName(string $name) { $this->name = $name; }
    public function setPrice(float $price) { $this->price = $price; }

}