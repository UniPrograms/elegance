<?php

require_once("Article.php");



class OrderItem{
    private ?int $id;
    private ?Article $article;
    private ?Order $order;

    public function __construct() {
        $this->id = null;
        $this->article = null;   
        $this->order = null;  
    }

    // Getter
    public function getId(): ?int { return $this->id; }
    public function getArticle(): ?Article { return $this->article; }
    public function getOrder(): ?Order { return $this->order; }
    // Setter
    public function setId(int $id) { $this->id = $id; }
    public function setArticle(?Article $article) { $this->article = $article; }
    public function setOrder(?Order $order) { $this->order = $order; }
}
?>