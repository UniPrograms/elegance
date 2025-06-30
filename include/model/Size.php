<?php

class Size{
    private ?int $id;
    private string $size;



    public function __construct(){
        $this->id = null;
        $this->size = '';
    }

    // Getter
    public function getId(): ?int {return $this->id;}
    public function getSize(): string {return $this->size;}


    // Setter
    public function setId(?int $id) { $this->id = $id; }
    public function setSize(string $size) { $this->size = $size; }



}
