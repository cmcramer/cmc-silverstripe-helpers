<?php
/*
 * String utility functions
 */
class CmcStringHelper {
    
    /*
     * @description spaces and other non-alphanumeric characters are removed
     *              and replaced with $repChar
     */
    public static function alphanumericWithCustom($str, $repChar='', $allowedChars='') {
        $strSafe = preg_replace("/[^A-Za-z0-9{$allowedChars}]/", $repChar, $str);
    
        return CmcStringHelper::removeDupes($strSafe);
    }
    /* @description this compares the value of a string and an alphnumeric string */
    public static function compareAlphanumericWithCustom($str, $alphaStr, $repChar='', $allowedChars='') {
        return (self::alphanumericWithCustom($str, $repChar, $allowedChars) == $alphaStr);
    }
    
    
    
    /**
     * @description Convert spaces to another character
     * 
     * @param string $str
     * @param string $repChar
     * @return string
     */
    public static function convertSpaces($str, $repChar='+') {
        return preg_replace('/\s+/', $repChar, $str);
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
    
    
    
    
    /** 
     * CONVENIENCE FUNCTIONS 
     * 
     * Also support backward compatibility
     */

    /*
     * @description spaces and other non-alphanumeric characters are replaced with dashes
     */
    public static function alphanumericWithDashes($str) {
        return CmcStringHelper::alphanumericWithCustom($str, '-', '-');
    }
    
    /* @description this compares the value of a string and an alphnumericWithDashes string */
    public static function compareAlphanumericWithDashes($str, $alphaStr) {
        return (self::alphanumericWithDashes($str) == $alphaStr);
    }
    
    /*
     * @description Allows spaces, but other non-alphanumeric characters are stripped.
     */
    public static function alphanumericWithSpaces($str) {
        return CmcStringHelper::alphanumericWithCustom($str, ' ', ' ');
    }
    
    /* @description this compares the value of a string and an alphnumericWithSpaces string */
    public static function compareAlphanumericWithSpaces($str, $alphaStr) {
        return (self::alphanumericWithSpaces($str) == $alphaStr);
    }

    
    /*
     * @description spaces and other non-alphanumeric characters are remove
     */
    public static function alphanumeric($str) {
        return CmcStringHelper::alphanumericWithCustom($str);
    }
    
    /* @description this compares the value of a string and an alphnumeric string */
    public static function compareAlphanumeric($str, $alphaStr) {
        return (self::alphanumeric($str) == $alphaStr);
    }
    
    
    
}