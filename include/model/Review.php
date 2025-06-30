<?php

require_once("Product.php");
require_once("User.php");


class Review{
    private ?int $id;
    private string $text;
    private ?Product $product;
    private ?User $user;
    private ?string $date;

    public function __construct() {
        $this->id = null;
        $this->text = "";
        $this->product = null;
        $this->user = null;
        $this->date = null;   
    }

    // Getter
    public function getId(): ?int { return $this->id; }
    public function getText(): ?string { return $this->text; }
    public function getUser(): ?User { return $this->user; }
    public function getProduct(): ?Product { return $this->product; }
    public function getDate(): ?string { return $this->date; }

    // Setter
    public function setId(int $id) { $this->id = $id; }
    public function setText(string $text) { $this->text =  $text; }
    public function setUser(?User $user) { $this->user = $user; }
    public function setProduct(?Product $product) { $this->product = $product; }
    public function setDate(?string $date) { $this->date = $date; }
}
?>