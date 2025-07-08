<?php



class Notify{
    private ?int $id;
    private ?User $user;
    private ?string $object;
    private ?string $text;
    private ?string $state;
    private ?string $date;


    public function __construct(){
        $this->id = null;
        $this->user = null;
        $this->object = '';
        $this->text = '';
        $this->state = '';
        $this->date = '';

    }



     // Getter
     public function getId(): ?int { return $this->id; }
     public function getUser(): ?User { return $this->user; }
     public function getObject(): ?string { return $this->object; }
     public function getText(): ?string { return $this->text; }
     public function getState(): ?string { return $this->state; }
     public function getDate(): ?string { return $this->date;}

     // Setter
     public function setId(?int $id): void { $this->id = $id; }
     public function setUser(?User $user): void { $this->user = $user; }
     public function setObject(?string $object): void { $this->object = $object; }
     public function setText(?string $text): void { $this->text = $text; }
     public function setState(?string $state): void { $this->state = $state; }
     public function setDate(?string $date): void { $this->date = $date;}

}












?>