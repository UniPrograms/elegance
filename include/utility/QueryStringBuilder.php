<?php


class QueryStringBuilder {

    private const INIT = "?"; 
    private const SEPARATOR = "&";
    private array $params = [];


    public function add(string $key, mixed $value){
        $this->params[$key] = $value;
    }

    public function build(): string{
        if(empty($this->params)){
            return "";
        }

        return self::INIT . http_build_query($this->params,'',self::SEPARATOR);
    }

}


?>