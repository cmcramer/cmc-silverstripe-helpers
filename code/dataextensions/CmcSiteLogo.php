<?php
/**
 * CmcSiteLogo
 *  
 * @author cmc
 *
 * @usage - 
 *      In _config/config.yml
 *      
 *          SiteConfig:
 *              extensions:
 *                  - CmcSiteLogo
 *                  
 *      In template
 *          
 *          $SiteConfig.LogoImage.SetRatio(250,250)
 *
 */
class CmcSiteLogo extends DataExtension {
    public static $has_one = array(
        'LogoImage' => 'Image',
    );
    
    public function updateCMSFields(FieldList $fields) {
        $fields->addFieldsToTab('Root.Main', new UploadField('LogoImage', 'Choose an image for your site logo'));
    }
}