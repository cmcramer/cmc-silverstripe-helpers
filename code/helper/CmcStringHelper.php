<?php
/*
 * String utility functions
 */
class CmcStringHelper {
    
    /*
     * @description spaces and other non-alphanumeric characters are replaced with dashes
     */
    public static function alphanumericWithDashes($str, $allowSpace=false) {
        
        if ( ! $allowSpace ) {
            $strSafe = preg_replace("/[^A-Za-z0-9]/", '-', $str);
        } else {
            $strSafe = preg_replace("/[^A-Za-z0-9 ]/", '-', $str);
        }
        return CmcStringHelper::removeDupes($strSafe);
    }
    
    /* @description this compares the value of a string and an alphnumericWithDashes string */
    public static function compareAlphanumericWithDashes($str, $alphaStr) {
        return (self::alphanumericWithDashes($str) == $alphaStr);
    }
    
    
    
    /*
     * @description Allows spaces, but other non-alphanumeric characters are stripped.
     */
    public static function alphanumericWithSpaces($str, $allowDash=false) {
        if ( ! $allowDash ) {
            $strSafe = preg_replace("/[^A-Za-z0-9 ]/", '', $str);
        } else {
            $strSafe = preg_replace("/[^A-Za-z0-9-]/", '', $str);
        }

        return CmcStringHelper::removeDupes($strSafe);
    }
    
    /* @description this compares the value of a string and an alphnumericWithSpaces string */
    public static function compareAlphanumericWithSpaces($str, $alphaStr) {
        return (self::alphanumericWithSpaces($str) == $alphaStr);
    }
    
    
    

    /*
     * @description spaces and other non-alphanumeric characters are remove
     */
    public static function alphanumeric($str, $allowSpace=false, $allowDash=false) {
        if ($allowSpace && $allowDash) {
            $strSafe = preg_replace("/[^A-Za-z0-9 -]/", '', $str);
        } elseif ($allowSpace) {
            $strSafe = preg_replace("/[^A-Za-z0-9 ]/", '', $str);
        } elseif ($allowDash) {
            $strSafe = preg_replace("/[^A-Za-z0-9-]/", '', $str);
        } else {
            $strSafe = preg_replace("/[^A-Za-z0-9]/", '', $str);
        }
        
        return CmcStringHelper::removeDupes($strSafe);
    }
    
    /* @description this compares the value of a string and an alphnumeric string */
    public static function compareAlphanumeric($str, $alphaStr) {
        return (self::alphanumeric($str) == $alphaStr);
    }
    
    
    
    /**
     * 
     * @return String with -- -> - and '  ' -> ''
     */
    private static function removeDupes($str) {
        //replace multiple spaces
        $str = preg_replace('/\s+/', ' ', $str);
        //replace multiple dashes
        $str = preg_replace('/-+/', '-', $str);
        
        return $str;
    }
    
}