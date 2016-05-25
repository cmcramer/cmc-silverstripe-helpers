<?php
/*
 * String utility functions
 */
class CmcUrlHelper {

    /**
     * Clean array key and values and create slashed string
     * @param Array $arr
     * @return string
     */
    public static function doSlashedString($arr, $skipKeysWith='', $removeSubmit=true) {
        $arrClean = CmcArrayHelper::spacesInValuesToPlus(CmcArrayHelper::cleanArray($arr));
        $strQuery = '';
        $first = true;
        foreach ($arrClean as $key => $value) {
            //skip if no value or submit
            if  ( $value == '' || ($key =='submit' && $removeSubmit) 
                    || ($skipKeysWith != '' && stristr($key, $skipKeysWith)) ) {
                continue;
                
            //otherwise append key/value to string
            } else {
                if (! $first) {
                    $strQuery .= '/';
                } else {
                    $first = false;
                } 
                $strQuery .= "{$key}/{$value}";
            }
                
        }
        return $strQuery;
    }
    
    
    
}