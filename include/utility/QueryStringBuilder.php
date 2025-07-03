<?php


class QueryStringBuilder {

    private string $path_file;
    private const INIT = "?"; 
    private const SEPARATOR = "&";
    private array $params = [];

     public function __construct($path_file){
        $this->path_file = $path_file; 
    }

    public function add(string $key, mixed $value){
        $this->params[$key] = $value;
    }

    public function build(): string{
        if(empty($this->params)){
            return "";
        }

        return $this->path_file . self::INIT . http_build_query($this->params,'',self::SEPARATOR);
    }

    public function clean(): void{
        $this->params = [];
    }
}


?>