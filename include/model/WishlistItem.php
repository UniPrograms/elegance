<?php

require_once("Article.php");


class WishlistItem{
    private ?int $id;
    private ?Article $article;

    public function __construct() {
        $this->id = null;
        $this->article = null;   
    }

    // Getter
    public function getId(): ?int { return $this->id; }
    public function getArticle(): ?Article { return $this->article; }

    // Setter
    public function setId(int $id) { $this->id = $id; }
    public function setArticle(?Article $article) { $this->article = $article; }
}
?>