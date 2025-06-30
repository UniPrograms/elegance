<?php

class Sex{
    private ?int $id;
    private string $sex;



    public function __construct(){
        $this->id = null;
        $this->sex = '';
    }

    // Getter
    public function getId(): ?int {return $this->id;}
    public function getSex(): string {return $this->sex;}


    // Setter
    public function setId(?int $id) { $this->id = $id; }
    public function setSex(string $sex) { $this->sex = $sex; }



}
