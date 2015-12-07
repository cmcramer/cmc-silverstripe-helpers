<?php
/*
 * String utility functions
 */
class CmcStringHelper {
    
    /*
     * @description spaces and other non-alphanumeric characters are replaced with dashes
     */
    public static function alphanumericWithDashes($str) {
        $strSafe = preg_replace("/[^A-Za-z0-9]/", '-', $str);
        return $strSafe;
    }
    
    /* @description this compares the value of a string and an alphnumericWithDashes string */
    public static function compareAlphanumericWithDashes($str, $alphaStr) {
        return (self::alphanumericWithDashes($str) == $alphaStr);
    }
    
    
    
    /*
     * @description Allows spaces, but other non-alphanumeric characters are stripped.
     */
    public static function alphanumericWithSpaces($str) {
        $strSafe = preg_replace("/[^A-Za-z0-9 ]/", '', $str);
        return $strSafe;
    }
    
    /* @description this compares the value of a string and an alphnumericWithSpaces string */
    public static function compareAlphanumericWithSpaces($str, $alphaStr) {
        return (self::alphanumericWithSpaces($str) == $alphaStr);
    }
    
    
    

    /*
     * @description spaces and other non-alphanumeric characters are remove
     */
    public static function alphanumeric($str) {
        $strSafe = preg_replace("/[^A-Za-z0-9]/", '', $str);
        return $strSafe;
    }
    
    /* @description this compares the value of a string and an alphnumeric string */
    public static function compareAlphanumeric($str, $alphaStr) {
        return (self::alphanumeric($str) == $alphaStr);
    }
    
    
}