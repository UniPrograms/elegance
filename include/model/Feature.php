<?php

require_once("include/model/Product.php");

class Feature{
    private ?int $id;
    private string $name;
    



    public function __construct(){
        $this->id = null;
        $this->name = "";
    }

    // Getter
    public function getId(): ?int {return $this->id;}
    public function getName(): string {return $this->name;}



    // Setter
    public function setId(?int $id) { $this->id = $id; }
    public function setName($name) { $this->name = $name; }

}