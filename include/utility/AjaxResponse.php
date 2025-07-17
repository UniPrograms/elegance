<?php


class AjaxResponse {
 
    private string $status;
    private array $params = [];

     public function __construct(string $status){
        $this->status = strtoupper($status); 
    }

    public function add(string $key, mixed $value){
        $this->params[strtolower($key)] = $value;
    }

    public function addEncode(string $key, mixed $value){
        $this->params[strtolower($key)] = base64_encode($value);
    }

    public function build(){
        $this->add("status",$this->status);
        return json_encode($this->params);
    }

    public function cleanParams(): void{
        $this->params = [];
    }

    public function refresh(string $status){
        $this->status = strtoupper($status); 
        $this->cleanParams();
    }

    public static function genericServerError(): AjaxResponse{
        $ajax_response = new AjaxResponse("ERROR");
        $ajax_response->add("title_message","Operazione non valida");
        $ajax_response->add("text_message","Il server non ha potuto elaborare la richiesta.");
        return $ajax_response;
    }


    public static function okNoContent(): AjaxResponse{
        $ajax_response = new AjaxResponse("OK");
        return $ajax_response;
    }

    
}


?>