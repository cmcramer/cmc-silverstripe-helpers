<?php
/*
 * String utility functions
 */
class CmcArrayHelper {
    
    private static $_default_rep_char = '';
    private static $_default_other_allowable_chars = ' _-';

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
     *      repChar             ''      | set to character to use to replace, non alphanumeric
     *                                      allowable replacement chars 
     *                                      '', ' ', '-', '_', '|', '+', '*', '%', '^'
     *      skipKeys            false   | if true, keys are left unchanged
     *      otherAllowableChars ' -_'   | allows space, dash, underscore by default
     *      lowerCase           true    | if false, case unchanged
     *      
     * @return array
     */
    public static function cleanArray($arrToClean, $params=array()) {
        //create param aarray for repChar
        $repChar = self::$_default_rep_char;
        if ( isset($params['repChar']) && 
                in_array($params['repChar'], 
                        array('', ' ', '-', '_', '|', '+', '*', '%', '^', ))
            ) {
            $repChar = false;
        }
        $arrRepChar = CmcArrayHelper::paramToArray(count($arrToClean), $repChar);
        
        $otherAllowableChars = self::$_default_other_allowable_chars;
        if ( isset($params['otherAllowableChars']) ) {
            $otherAllowableChars = $params['otherAllowableChars'];
        }
        //string contains dash move to end or preg won't work
        if (stristr($otherAllowableChars, '-')) {
            $otherAllowableChars = str_replace('-', '', $otherAllowableChars).'-';
        }
        $arrAllowableChars = CmcArrayHelper::paramToArray(count($arrToClean), $otherAllowableChars);
        
        
        //Set $cleanArray
        $cleanArray = array_map('CmcStringHelper::alphanumericWithCustom',
                                     $arrToClean,
                                     $arrRepChar,
                                     $arrAllowableChars);
        
        
        //make lower case unless set false
        if (  ! isset($params['lowerCase'])   ||   ! ($params['lowerCase'] == false) )  {
            $cleanArray = array_map('strtolower', $cleanArray);
        }
        
        
        //clean keys unless set to skip
        $cleanKeys = array_keys($arrToClean);
        if ( ! isset($params['skipKeys'])   || ! ($params['skipKeys'] == true)) {
            //Don't check keys for key arrays
            $params['skipKeys'] = true;
            $params['otherAllowableChars'] = str_replace(' ', '', $otherAllowableChars);
            //clean the keys array
            $cleanKeys = CmcArrayHelper::cleanArray($cleanKeys, $params);
            //combine the cleaned keys and  values
        }
        //keys get wiped out even if skipped if not combined after mapping
        $cleanArray = array_combine($cleanKeys, array_values($cleanArray));
        
        return $cleanArray;
        
    }
    
    
    
    public static function spacesInValuesToPlus($arrToClean) {
        $arrKeys = array_keys($arrToClean);
        $arrPlus = CmcArrayHelper::paramToArray(count($arrToClean), '+');
        $arrConverted = array_map('CmcStringHelper::convertSpaces', $arrToClean, $arrPlus);
        return array_combine($arrKeys, array_values($arrConverted));
    }
    
    
    
    
    
    /**
     * Primarily used by array_to provide additional arguments to functions
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