<?php
/**
 * CmcSiteShortTitle
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
 *                  - CmcSiteShortTitle
 *
 *      In template
 *
 *          $SiteConfig.ShortTitle
 *
 */
class CmcSiteShortTitle extends DataExtension {
    private static $db = array(
        'ShortTitle'    => 'Varchar(50)',
    );

    public function updateCMSFields(FieldList $fields) {
        $fields->addFieldToTab("Root.Main", new TextField("ShortTitle", "Site Short Title"));
    }
    
//     public function CmcSiteShortTitle() {
//         if ($this->owner->SiteShortTitle && $this->owner->SiteShortTitle != '') {
//             return $this->owner->SiteShortTitle;
//         }
//         return '';
//     }
}