<?php

require_once("include/model/Wishlist.php");

class WishlistProxy extends Wishlist{


    private ?DataLayer $dataLayer;
    private int $userId;

    public function __construct(?DataLayer $dataLayer){
        parent::__construct();
        $this->dataLayer = $dataLayer;
    }



    // Setter and Getter
    public function getUserId(): int {return $this->userId;}

    public function setUserId(int $userId): void {$this->userId = $userId;}


    //Override Getter
    public function getWishlistItem(): ?array{
        if(parent::getWishlistItem() == null && $this->id > 0){
            parent::setWishlistItem((($this->dataLayer)->getWishlistItemDAO())->getWishlistItemByWishlist($this));
        }
        return parent::getWishlistItem();
    }

}
