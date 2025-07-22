<?php

require_once("Article.php");

class Cart{

    protected ?int $id;
    protected ?User $user;
    protected ?array $cartItem;
    protected ?float $price;

    public function __construct()    {
        $this->id = null;
        $this->user = null;
        $this->cartItem = null;
        $this->price = 0;
    }

    // Getter
    public function getId(): ?int{return $this->id;}
    public function getUser(): ?User {return $this->user;}
    public function getCartItem(): ?array{return $this->cartItem;}
    public function getPrice(): ?float{return $this->price;}
    public function getSize(): ?int{return count($this->getCartItem());}


    // Setter
    public function setId(int $id){$this->id = $id;}
    public function setUser(?User $user){$this->user = $user;}
    public function setCartItem(?array $cartItem){$this->cartItem = $cartItem;}
    public function setPrice(?float $price){$this->price = $price;}
    

} 
