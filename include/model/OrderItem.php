<?php

require_once("Article.php");



class OrderItem{
    private ?int $id;
    private ?Article $article;
    private ?int $quantity;

    public function __construct() {
        $this->id = null;
        $this->article = null;   
    }

    // Getter
    public function getId(): ?int { return $this->id; }
    public function getArticle(): ?Article { return $this->article; }
    public function getQuantity(): ?int { return $this->quantity; }

    // Setter
    public function setId(int $id) { $this->id = $id; }
    public function setArticle(?Article $article) { $this->article = $article; }
    public function setQuantity(int $quantity) { $this->quantity = $quantity; }
}
?>