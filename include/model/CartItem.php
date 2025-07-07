<?php

require_once("Article.php");


class CartItem{
    private ?int $id;
    private ?Article $article;
    private ?Cart $cart;

    public function __construct() {
        $this->id = null;
        $this->article = null;   
        $this->cart = null;
    }

    // Getter
    public function getId(): ?int { return $this->id; }
    public function getArticle(): ?Article { return $this->article; }
    public function getCart(): ?Cart{ return $this->cart; }


    // Setter
    public function setId(int $id) { $this->id = $id; }
    public function setArticle(?Article $article) { $this->article = $article; }
    public function setCart(?Cart $cart) {$this->cart = $cart;}

}
?>