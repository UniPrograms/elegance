<?php

require_once("Product.php");
require_once("User.php");


class Evaluation{
    private ?int $id;
    private int $star;
    private ?Product $product;
    private ?User $user;

    public function __construct() {
        $this->id = null;
        $this->star = 0;
        $this->product = null;
        $this->user = null;
    }

    // Getter
    public function getId(): ?int { return $this->id; }
    public function getStar(): int { return $this->star; }
    public function getUser(): ?User { return $this->user; }
    public function getProduct(): ?Product { return $this->product; }

    // Setter
    public function setId(int $id) { $this->id = $id; }
    public function setStar(int $star) { $this->star =  $star; }
    public function setUser(?User $user) { $this->user = $user; }
    public function setProduct(?Product $product) { $this->product = $product; }
}
?>