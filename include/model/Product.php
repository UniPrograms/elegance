<?php

require_once("Productor.php");
require_once("Category.php");
require_once("Sex.php");

class Product {
    protected ?int $id;
    protected String $name;
    protected float $price;
    protected string $description;
    protected ?Productor $productor;
    protected ?Category $category; 
    protected ?Sex $sex;
    protected ?array $images;
    protected ?array $features; 

    public function __construct() {
        $this->id = null;
        $this->name = "";
        $this->price = 0.0;
        $this->productor = null;
        $this->category = null;
        $this->sex = null;
        $this->images = null;
        $this->features = null;
    }

    // Getter
    public function getId(): ?int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getPrice(): float { return $this->price; }
    public function getDescription(): string { return $this->description; }
    public function getProductor(): ?Productor { return $this->productor; }
    public function getCategory(): ?Category { return $this->category; }
    public function getSex(): ?Sex { return $this->sex; } 
    public function getImages(): ?array { return $this->images; } 
    public function getFeatures(): ?array { return $this->features; } 

    // Setter
    public function setId(?int $id) { $this->id = $id; }
    public function setName(string $name) { $this->name = $name; }
    public function setPrice(float $price) { $this->price = $price; }
    public function setDescription(string $description) { $this->description = $description; }
    public function setProductor(?Productor $productor) { $this->productor = $productor; }
    public function setCategory(?Category $category) { $this->category = $category; }
    public function setSex(?Sex $sex) {$this->sex = $sex;}
    public function setImages(?array $images) {$this->images = $images;}
    public function setFeatures(?array $features) {$this->features = $features;}
}