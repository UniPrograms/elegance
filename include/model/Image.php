<?php

require_once("include/model/Product.php");

class Image{
    private ?int $id;
    private String $name;
    private String $path;

    public function __construct() {
        $this->id = null;
        $this->name = "";
        $this->path = "";
    }

    // Getter
    public function getId(): ?int { return $this->id; }
    public function getName(): String { return $this->name; }
    public function getPath(): String {return $this->path;}

    // Setter
    public function setId(int $id) { $this->id = $id; }
    public function setName(String $name) { $this->name = $name; }
    public function setPath(String $path) { $this->path = $path; }
}

?>