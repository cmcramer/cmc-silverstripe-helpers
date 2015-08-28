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
        'Logo2Image' => 'Image',
    );
    
    public static $db = array(
        'LogoUrl'       => 'Varchar(250)',
        'LogoUrlTitle'  => 'Varchar(120)',
        'Logo2Url'      => 'Varchar(250)',
        'Logo2UrlTitle' => 'Varchar(120)',
    );
    
    public function updateCMSFields(FieldList $fields) {
        $fields->addFieldsToTab('Root.Main', new UploadField('LogoImage', 'Choose an image for your site logo'));
        $fields->addFieldToTab("Root.Main", new TextField("LogoUrl", "Optionally enter URL to link to from logo image"));
        $fields->addFieldToTab("Root.Main", new TextField("LogoUrlTitle", "Title/Tooltip text for URL above"));
        $fields->addFieldsToTab('Root.Main', new UploadField('Logo2Image', 'Choose an image for your 2nd site logo'));
        $fields->addFieldToTab("Root.Main", new TextField("Logo2Url", "Optionally enter URL to link to from 2nd logo image"));
        $fields->addFieldToTab("Root.Main", new TextField("Logo2UrlTitle", "Title/Tooltip text for URL above"));
    }
}