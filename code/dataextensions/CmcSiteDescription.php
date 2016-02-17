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
class CmcSiteDescription extends DataExtension {
    private static $db = array(
        'Description'    => 'Text',
    );

    public function updateCMSFields(FieldList $fields) {
        $fields->addFieldToTab("Root.Main", new TextareaField("Description", "Site Description"));
    }
    
}