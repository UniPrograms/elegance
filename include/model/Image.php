<?php

require_once("include/model/Product.php");

class Image{
    private ?int $id;
    private String $path;
    private ?Product $product;

    public function __construct() {
        $this->id = null;
        $this->path = "";
    }

    // Getter
    public function getId(): ?int { return $this->id; }
    public function getPath(): String {return $this->path;}
    public function getProduct(): ?Product { return $this->product; }

    // Setter
    public function setId(int $id) { $this->id = $id; }
    public function setPath(String $path) { $this->path = $path; }
    public function setProduct(?Product $product) { $this->product = $product; }
}

?>