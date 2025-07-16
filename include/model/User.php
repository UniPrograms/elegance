<?php

class User{
    private ?int $id;
    private ?string $name;
    private ?string $surname;
    private ?string $email;
    private ?string $password;
    private ?string $role;
    private ?string $urlImage;
    private ?string $phoneNumber;
    private ?string $registrationDate;



    public function __construct(){
        $this->id = null;
        $this->name = '';
        $this->surname = '';
        $this->email = '';
        $this->password = '';
        $this->role = '';
        $this->urlImage = '';
        $this->phoneNumber = '';
        $this->registrationDate = '';
        
    }

    // Getter
    public function getId(): ?int {return $this->id;}
    public function getName(): ?string {return $this->name;}
    public function getSurname(): ?string {return $this->surname;}
    public function getEmail(): ?string {return $this->email;}
    public function getPassword(): ?string {return $this->password;}
    public function getRole(): ?string {return $this->role;}
    public function getImage(): ?string {return $this->urlImage;}
    public function getPhoneNumber(): ?string {return $this->phoneNumber;}
    public function getRegistrationDate(): ?string {return $this->registrationDate;}


    // Setter
    public function setId(?int $id) { $this->id = $id; }
    public function setName(?string $name) { $this->name = $name; }
    public function setSurname(?string $surname) { $this->surname = $surname; }
    public function setEmail(?string $email) { $this->email = $email; }
    public function setPassword(?string $password) { $this->password = $password; }
    public function setRole(?string $role) { $this->role = $role; }
    public function setUrlImage(?string $urlImage) { $this->urlImage = $urlImage; }
    public function setPhoneNumber(?string $phoneNumber) { $this->phoneNumber = $phoneNumber; }
    public function setRegistrationDate(?string $registrationDate) { $this->registrationDate = $registrationDate; }

    // Other function
    public function toString(): ?string {return $this->name ." ".$this->surname;}

}
