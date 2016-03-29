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
class CmcInfoEmail extends DataExtension {
    private static $db = array(
        'Email'     => 'Varchar(254)',
        'Subject'   => 'Varchar(254)',
    );

    public function updateCMSFields(FieldList $fields) {
        $fields->addFieldToTab("Root.Main", new TextField("Email", "Site Info Email"));
    }
    
    public function EncodedSiteInfoEmail($label='') {
        if ($label == '') {
            $label=$email;
        }
        if ($this->Subject != '') { //set subject
            $mailString  = '<a href="' . encode('mailto:' . $this->Email);
            $mailString .= '?subject=' . $subject . '">';
        } else {              //no subject
            $mailString  = '<a href="' . encode('mailto:' . $this->Email) . '" >';
        }
        $mailString  .= '<span class="email">' . encode($label) . '</span></a>';
        return $mailString;
    }
    
}