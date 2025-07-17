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
            default:
                $result = $data;
                break;
        }
        return $result;
    }



    public function idformatter($name, $data, $pars){
        return "#". str_pad($data, 8, "0", STR_PAD_LEFT); 
    }

    public function enumformatter($name, $data, $pars){
        
        $formatted = str_replace('_', ' ', $data);
    
        $formatted = ucwords(strtolower($formatted));

        return $formatted;
    }

   
}
