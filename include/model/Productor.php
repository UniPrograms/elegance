<?php

class Productor{

    private ?int $id;
    private ?string $name;
    private ?string $logo;


    public function __construct(){
        $this->id = null;
        $this->name = '';
        $this->logo = '';
    }


    // Getter
    public function getId(): ?int {return $this->id;}
    public function getName(): ?string {return $this->name;}
    public function getLogo(): ?string {return $this->logo;}



    // Setter
    public function setId(?int $id) { $this->id = $id; }
    public function setName(?string $name) { $this->name = $name; }
    public function setLogo(?string $logo) { $this->logo = $logo; }

}



