<?php
class CmcNumberFormat {
    
    
    /*
     * returns decimal value in simplest form -
     * int
     * decimal with max two decimal places
     */ 
    public static function NiceInt($decimal) {
        
        if ($decimal == '') return '';
        
        $decimal = str_replace(',', '', $decimal);
        
        if ($decimal == intval($decimal)) {
            return number_format($decimal, 0); //use number format to add thousand separators
        }
        
        //not an int, check to see if it's an even fraction
        $roundedDecimal = round($decimal, 2);
        
        $int = floor($roundedDecimal);  
        $fraction = $roundedDecimal - $whole;
        
        //check to see if this is an even tenth
        $tenth = $fraction * 10;
        if ($tenth == intval($tenth)) { //this is a tenth just return 1 decimal place
            return number_format($roundedDecimal, 1);
        }
        
        else return number_format($roundedDecimal, 2);
        
    }
    
    
    /*
     * returns decimal value in simplest form -
     * int
     * int with 1/4, 1/3, 1/2, 2/3, 3/4 fraction
     * decimal with max two decimal places
     */ 
    public static function NiceFraction($decimal) {
        
        if ($decimal == '') return '';
        
        $decimal = str_replace(',', '', $decimal);
        
        if ($decimal == intval($decimal)) {
            return number_format($decimal, 0); //use number format to add thousand separators
        }
        
        //not an int, check to see if it's an even fraction
        $roundedDecimal = round($decimal, 2);
        
        $int = floor($roundedDecimal);  
        $fraction = $roundedDecimal - $int;
        
        switch ($fraction) {
            case 0.25 :
                $strFraction = '1/4';
                break;
            case 0.33 :
                $strFraction = '1/3';
                break;
            case 0.5 :
                $strFraction = '1/2';
                break;
            case 0.67 :
                $strFraction = '2/3';
                break;
            case 0.75 :
                $strFraction = '3/4';
                break;
            default:
                $strFraction = '';
        }
        
        //we have a whole fraction return the value
        if ($strFraction != '') {
            return "$int $strFraction";
        }
        
        else return self::NiceInt($decimal);
        
    }
}