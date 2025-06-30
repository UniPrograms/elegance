<?php

class Color{
    private ?int $id;
    private string $color;



    public function __construct(){
        $this->id = null;
        $this->color = "";
    }

    // Getter
    public function getId(): ?int {return $this->id;}
    public function getColor(): string {return $this->color;}


    // Setter
    public function setId(?int $id) { $this->id = $id; }
    public function setColor(string $color) { $this->color = $color; }


}