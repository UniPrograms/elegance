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
    private ?string $cap;
    private ?string $name;
    private ?string $surname;
    private ?string $phoneNumber;
    private ?string $email; 
    private ?string $provincia;

    public function __construct()    {
        $this->id = null;
        $this->nazione = "";
        $this->citta = "";
        $this->via = "";
        $this->civico = "";
        $this->cap = "";
        $this->name = "";
        $this->surname = "";
        $this->phoneNumber = "";
        $this->email = "";
        $this->provincia = "";
    }

    // Getter
    public function getId(): ?int{return $this->id;}
    public function getNazione(): ?string{return $this->nazione;}
    public function getCitta(): ?string{return $this->citta;}
    public function getVia(): ?string{return $this->via;}
    public function getCivico(): ?string{return $this->civico;}
    public function getCAP(): ?string{return $this->cap;}
    public function getName(): ?string{return $this->name;}
    public function getSurname(): ?string{return $this->surname;}
    public function getPhoneNumber(): ?string{return $this->phoneNumber;}
    public function getEmail(): ?string{return $this->email;}
    public function getProvincia(): ?string{return $this->provincia;}

    // Setter
    public function setId(int $id){$this->id = $id;}
    public function setNazione(?string $nazione) {$this->nazione = $nazione;}
    public function setCitta(?string $citta){ $this->citta = $citta;}
    public function setVia(?string $via) { $this->via = $via;}
    public function setCivico(?string $civico) { $this->civico = $civico;}
    public function setCAP(?string $cap) { $this->cap = $cap;}
    public function setName(?string $name) { $this->name = $name;}
    public function setSurname(?string $surname) { $this->surname = $surname;}
    public function setPhoneNumber(?string $phoneNumber) { $this->phoneNumber = $phoneNumber;}
    public function setEmail(?string $email) { $this->email = $email;}
    public function setProvincia(?string $provincia) { $this->provincia = $provincia;}

    // Other Methods
    public function toString(): string{

        return $this->via . " ". $this->civico . ", ". $this->citta . ", ". $this->nazione;
        
    }
}
