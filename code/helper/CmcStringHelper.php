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
    
    /*
     * @description Allows spaces, but other non-alphanumeric characters are stripped.
     */
    public static function alphanumericWithSpaces($str) {
        $strSafe = preg_replace("/[^A-Za-z0-9 ]/", '', $str);
        return $strSafe;
    }
}