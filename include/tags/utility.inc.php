<?php

class utility extends TagLibrary
{



    public function injectStyle() {}

    // Name indica il nome del placeholder
    // Data indica il dato inserito
    // Pars indica eventuali parametri (è un array)

    public function strformatter($name, $data, $pars) {

        switch($pars["type"]){
            case "upper":
                $result = strtoupper($data);
                break;
            case "lower":
                $result = strtolower($data);
                break;
            case "capitalize":
                $result = ucfirst(strtolower($data));
                break;
            case "title":
                $result = ucwords(strtolower($data));
                break;
            case "phone":
                $result = substr($data, 0, 3) . " " . substr($data, 3, 3) . " " . substr($data, 6, 4);
                break;
            default:
                $result = $data;
                break;
        }
        
        // Gestione del parametro truncate
        if (isset($pars["truncate"]) && is_numeric($pars["truncate"])) {
            $maxLength = (int)$pars["truncate"];
            if (strlen($result) > $maxLength) {
                $result = substr($result, 0, $maxLength) . "...";
            }
        }
        
        return $result;
    }



    public function idformatter($name, $data, $pars){
        if(empty($data)){
            return "";
        }
        return "#". str_pad($data, 8, "0", STR_PAD_LEFT); 
    }

    public function enumformatter($name, $data, $pars){
        
        $formatted = str_replace('_', ' ', $data);
    
        $formatted = ucwords(strtolower($formatted));

        return $formatted;
    }

   
}
