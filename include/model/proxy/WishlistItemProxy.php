<?php

require_once("include/model/WishlistItem.php");

class WishlistItemProxy extends WishlistItem{


    private ?DataLayer $dataLayer;
    private int $articleId;
    private int $wishlistId;

    public function __construct(?DataLayer $dataLayer){
        parent::__construct();
        $this->dataLayer = $dataLayer;
    }



    // Setter and Getter
    public function getArticleId(): int {return $this->articleId;}

    public function setArticleId(int $articleId): void {$this->articleId = $articleId;}

    public function setWishlistId(INT $wishlistId): void {$this->wishlistId = $wishlistId;}


    //Override Getter
    public function getArticle(): ?Article{
        if(parent::getArticle() == null && $this->articleId > 0){
            parent::setArticle((($this->dataLayer)->getArticleDAO())->getArticleById($this->articleId));
        }
        return parent::getArticle();
    }


    public function getWishlist(): ?Wishlist{
        if(parent::getWishlist() == null && $this->wishlistId > 0){
            parent::setWishlist((($this->dataLayer)->getWishlistDAO())->getWishlistById($this->wishlistId));
        }
        return parent::getWishlist();
    }

}
