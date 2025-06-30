<?php

require_once("Product.php");
require_once("Size.php");
require_once("Color.php");

class Article{

    private ?int $id;
    private ?Product $product;
    private ?Size $size;
    private ?Color $color;
    private int $quantity;

    public function __construct()    {
        $this->id = null;
        $this->product = null;
        $this->size = null;
        $this->color = null;
        $this->quantity = 0;
    }

    // Getter
    public function getId(): ?int{return $this->id;}
    public function getProduct(): ?Product{return $this->product;}
    public function getSize(): ?Size{return $this->size;}
    public function getColor(): ?Color{return $this->color;}
    public function getQuantity(): int{return $this->quantity;}

    // Setter
    public function setId(int $id){$this->id = $id;}
    public function setProduct(?Product $product){$this->product = $product;}
    public function setSize(?Size $size){$this->size = $size;}
    public function setColor(?Color $color){$this->color = $color;}
    public function setQuantity(?int $quantity){$this->quantity = $quantity;}

}
