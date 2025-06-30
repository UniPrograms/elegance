<?php

require_once("include/model/Feature.php");

class ProductFeature{

    private ?int $id;
    private ?Feature $feature;    
    private string $description;

    public function __construct(){
        $this->id = null;
        $this->feature = null;        
        $this->description = "";
    }

    // Getter
    public function getId(): ?int {return $this->id;}
    public function getDescription(): string {return $this->description;}
    public function getFeature(): ?Feature {return $this->feature;}



    // Setter
    public function setId(?int $id) {$this->id = $id;}
    public function setDescription(string $description) {$this->description = $description;}
    public function setFeature(?Feature $feature) {$this->feature = $feature;}

}