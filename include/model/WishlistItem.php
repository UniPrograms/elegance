<?php

require_once("Article.php");


class WishlistItem{
    private ?int $id;
    private ?Article $article;
    private ?Wishlist $wishlist;

    public function __construct() {
        $this->id = null;
        $this->article = null; 
        $this->wishlist = null;  
    }

    // Getter
    public function getId(): ?int { return $this->id; }
    public function getArticle(): ?Article { return $this->article; }
    public function getWishlist(): ?Wishlist{return $this->wishlist; }

    // Setter
    public function setId(int $id) { $this->id = $id; }
    public function setArticle(?Article $article) { $this->article = $article; }
    public function setWishlist(?Wishlist $wishlist) {$this->wishlist = $wishlist;}
}
?>