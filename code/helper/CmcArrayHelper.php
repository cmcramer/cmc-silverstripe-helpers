<?php
/*
 * String utility functions
 */
class CmcArrayHelper {

    /**
     * @description Default settings return cleaned array
     *      - keys default to
     *          - alphnumeric only and lower case
     *          - spaces and dashes never allowed, regardless of other settings
     *          - if lowerCase set to false case of keys is left unchanged
     *          - if don't want to clean keys set skipKeys to true
     *      - values default to 
     *          - non-alphanumeric characters replaced with ''
     *          - spaces are allowed, but multiple spaces in a row replaced with one
     *          - existing dashes are allowed
     *          - lower case
     * 
     * @param Array $arrToClean
     * @param Array $params, allowable keys
     *      skipKeys    false   | if true, doesn't clean keys
     *      allowSpace  true    | if false, no spaces are allowed in cleaned values
     *                  false (for keys)
     *      allowDash   true    | if false, dashes are stripped from string
     *      useSpace    false   | if true, replaces with space instead of ''
     *      useDash     false   | if true, replaces with dash instead of ''
     *                              on allowSpace or allowDash options
     *      lowerCase   true    | if false, case unchanged
     *      
     * @return array
     */
    public static function cleanArray($arrToClean, $params=array()) {
        //create param aarray for allowSpace
        $allowSpace = true;
        if (isset($params['allowSpace']) && $params['allowSpace'] == false) {
            $allowSpace = false;
        }
        $arrAllowSpace = CmcArrayHelper::paramToArray(count($arrToClean), $allowSpace);
        //create param array for allowDash
        $allowDash = true;
        if (isset($params['allowDash']) && $params['allowDash'] == false) {
            $allowDash = false;
        }
        $arrAllowDash = CmcArrayHelper::paramToArray(count($arrToClean), $allowDash);
        
        
        //Set $cleanArray
        if ( isset($params['useSpace']) && $params['useSpace'] == true ) {
            $cleanArray = array_map('CmcStringHelper::alphanumericWithSpaces', 
                                     $arrToClean,
                                     $arrAllowDash);
        } elseif ( isset($params['useDash']) && $params['useDash'] == true ) {
            //default
            $cleanArray = array_map('CmcStringHelper::alphanumericWithDashes',
                                     $arrToClean,
                                     $arrAllowSpace);
        } else {
            $cleanArray = array_map('CmcStringHelper::alphanumeric',
                                     $arrToClean,
                                     $arrAllowSpace,
                                     $arrAllowDash);
        }
        
        //make lower case unless set false
        if (  ! isset($params['lowerCase'])   ||   ! ($params['lowerCase'] == false) )  {
            $cleanArray = array_map('strtolower', $cleanArray);
        }
        
        
        //clean keys unless set to skip
        if ( ! isset($params['skipKeys'])   || ! ($params['skipKeys'] == true)) {
            $arrKeys = array_keys($arrToClean);
            //cleaning array of keys, don't want endless loop
            $params['skipKeys'] = true;
            //don't allow spaces or dashes in keys
            $params['allowSpace'] = false;
            $params['allowDash']  = false;
            //clean the keys array
            $cleanKeys = CmcArrayHelper::cleanArray($arrKeys, $params);
            //combine the cleaned keys and  values
            $cleanArray = array_combine($cleanKeys, array_values($cleanArray));
        }
        
        return $cleanArray;
        
    }
    
    /**
     * Creates array of length passed with all values set to $value
     * @param unknown $arrLen
     * @param unknown $param
     * @return multitype:unknown
     */
    public static function paramToArray($count, $value) {
        $arr = array();
        
        for ($i=0;$i<$count;$i++) {
            $arr[] = $value;
        }
        
        return $arr;
    }
    
    
}