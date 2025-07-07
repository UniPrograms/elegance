<?php

require_once("Product.php");
require_once("Size.php");
require_once("Color.php");

class Address{

    private ?int $id;
    private ?string $nazione;
    private ?string $citta;
    private ?string $via;
    private ?string $civico;
    private ?int $cap;
   

    public function __construct()    {
        $this->id = null;
        $this->nazione = "";
        $this->citta = "";
        $this->via = "";
        $this->civico = "";
        $this->cap = null;
    }

    // Getter
    public function getId(): ?int{return $this->id;}
    public function getNazione(): ?string{return $this->nazione;}
    public function getCitta(): ?string{return $this->citta;}
    public function getVia(): ?string{return $this->via;}
    public function getCivico(): ?string{return $this->civico;}
    public function getCAP(): ?int{return $this->cap;}

    // Setter
    public function setId(int $id){$this->id = $id;}
    public function setNazione(?string $nazione) {$this->nazione = $nazione;}
    public function setCitta(?string $citta){ $this->citta = $citta;}
    public function setVia(?string $via) { $this->via = $via;}
    public function setCivico(?string $civico) { $this->civico = $civico;}
    public function setCAP(?string $cap) { $this->cap = $cap;}

    // Other Methods
    public function toString(): string{

        return $this->via . " ". $this->civico . ", ". $this->citta . ", ". $this->nazione;
        
    }
}
