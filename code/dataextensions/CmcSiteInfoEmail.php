<?php
/**
 * CmcSiteInfoEmail
 *
 * @author cmc
 * 
 *
 * @usage -
 *  
 *      In _config/config.yml
 *
 *          SiteConfig:
 *              extensions:
 *                  - CmcSiteInfoEmail
 *
 *      In template
 *
 *          $SiteConfig.InfoEmail
 *
 */
class CmcSiteInfoEmail extends DataExtension {
    private static $db = array(
        'Email'     => 'Varchar(254)',
        'Subject'   => 'Varchar(254)',
    );

    public function updateCMSFields(FieldList $fields) {
        $fields->addFieldToTab("Root.Main", new TextField("Email", "Site Info Email"));
        $fields->addFieldToTab("Root.Main", new TextField("Subject", "Email Subject"));
    }
    
    public function EncodedSiteInfoEmail($label='') {
        if ($label == '') {
            $label=$this->owner->Email;
        }
        if ($this->owner->Subject != '') { //set subject
            $mailString  = '<a href="' . $this->_encode('mailto:' . $this->owner->Email);
            $mailString .= '?subject=' . $this->owner->Subject . '">';
        } else {              //no subject
            $mailString  = '<a href="' . $this->_encode('mailto:' . $this->owner->Email) . '" >';
        }
        $mailString  .= '<span class="email">' . $this->_encode($label) . '</span></a>';
        return $mailString;
    }
    
    private function _encode($string)  {
        $encoded = '';
        for ($i=0; $i < strlen($string); $i++) {
        $encoded .= '&#'.ord(substr($string,$i)).';';
        }
        return $encoded;
    }
    
}