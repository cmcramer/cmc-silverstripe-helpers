<?php
/**
 * CmcSiteHeaderImage
 *  
 * @author cmc
 *
 * @usage - 
 *      In _config/config.yml
 *      
 *          SiteConfig:
 *              extensions:
 *                  - CmcSiteHeagerImage
 *                  
 *      In template
 *          
 *          $SiteConfig.HeaderImage.SetRatio(250,250)
 *
 */
class CmcSiteHeaderImage extends DataExtension {
    public static $has_one = array(
        'HeaderImage' => 'Image',
    );
    
    public function updateCMSFields(FieldList $fields) {
        $fields->addFieldsToTab('Root.Main', new UploadField('HeaderImage', 'Choose an image for your site header'));
    }
}