<?php
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
    public static function doSlashedString($arr, $removeSubmit=true) {
        $arrClean = CmcArrayHelper::spacesInValuesToPlus(CmcArrayHelper::cleanArray($arr));
        $strQuery = '';
        $first = true;
        foreach ($arrClean as $key => $value) {
            //skip if no value or submit
            if  ( $value == '' || ($key =='submit' && $removeSubmit) ) {
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



    public static function cleanArray($arrToClean, $params=array()) {
        //create param aarray for repChar
        $repChar = '';
        if ( isset($params['repChar']) &&
            in_array($params['repChar'],
                array('', ' ', '-', '|', '+', '*', '%'))
        ) {
            $repChar = false;
        }
        $arrRepChar = CmcArrayHelper::paramToArray(count($arrToClean), $repChar);

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
        $cleanArray = array_map('CmcStringHelper::alphanumericWithCustom',
            $arrToClean,
            $arrRepChar,
            $arrAllowSpace,
            $arrAllowDash);


        //make lower case unless set false
        if (  ! isset($params['lowerCase'])   ||   ! ($params['lowerCase'] == false) )  {
            $cleanArray = array_map('strtolower', $cleanArray);
        }


        //clean keys unless set to skip
        $cleanKeys = array_keys($arrToClean);
        if ( ! isset($params['skipKeys'])   || ! ($params['skipKeys'] == true)) {
            //cleaning array of keys, don't want endless loop
            $params['skipKeys'] = true;
            //don't allow spaces or dashes in keys
            $params['allowSpace'] = false;
            $params['allowDash']  = false;
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