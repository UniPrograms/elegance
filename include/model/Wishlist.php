<?php

require_once("User.php");

class Wishlist{

    protected ?int $id;
    protected ?User $user;
    protected ?array $wishlistItem;


    public function __construct()    {
        $this->id = null;
        $this->user = null;
        $this->wishlistItem = null;
    }

    // Getter
    public function getId(): ?int{return $this->id;}
    public function getUser(): ?User {return $this->user;}
    public function getWishlistItem(): ?array{return $this->wishlistItem;}
    public function getSize(): ?int{return count($this->getWishlistItem());}
    // Setter
    public function setId(int $id){$this->id = $id;}
    public function setUser(?User $user){$this->user = $user;}
    public function setWishlistItem(?array $wishlistItem){$this->wishlistItem = $wishlistItem;}

}
