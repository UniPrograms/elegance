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

    public static function genericServerError(?string $message = null): AjaxResponse{
        $ajax_response = new AjaxResponse("GENERIC_ERROR");
        $ajax_response->add("title_message","Errore generico.");
        $ajax_response->add("text_message", $message ?? "Il server non ha potuto elaborare la richiesta.");
        return $ajax_response;
    }

    public static function sessionError(?string $message = null): AjaxResponse{
        $ajax_response = new AjaxResponse("SESSION_ERROR");
        $ajax_response->add("title_message","Errore di sessione.");
        $ajax_response->add("text_message", $message ?? "La sessione non è attiva.");
        return $ajax_response;
    }

    public static function okNoContent(?string $message = null): AjaxResponse{
        $ajax_response = new AjaxResponse("OK");
        $ajax_response->add("title_message","Operazione completata.");
        $ajax_response->add("text_message", $message ?? "L'operatione è andata a buon fine.");
        return $ajax_response;
    }

    public static function noOperationError(?string $message = null): AjaxResponse{
        $ajax_response = new AjaxResponse("OPERATION_ERROR");
        $ajax_response->add("title_message","Nessuna operazione selezionata.");
        $ajax_response->add("text_message", $message ?? "Nessuna operazione è stata selezionata.");
        return $ajax_response;
    }
    
    
}


?>