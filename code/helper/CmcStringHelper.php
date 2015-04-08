<?php
/*
 * String utility functions
 */
class CmcStringHelper {
    
    public static function alphanumericWithDashes($str) {
        $strSafe = preg_replace("/[^A-Za-z0-9]/", '-', $str);
        return $strSafe;
    }
}