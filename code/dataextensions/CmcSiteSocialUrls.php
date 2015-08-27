<?php

/**
 * CmcSiteSocialUrls
 *
 * @author cmc
 *
 * @usage -
 *      In _config/config.yml
 *
 *          SiteConfig:
 *              extensions:
 *                  - CmcSiteSocialUrls
 *
 *      In template
 *
 *          <a href="$SiteConfig.FacebookUrl">Visit my facebook page</a>
 *
 */
class CmcSiteSocialUrls extends DataExtension {
    public static $db = array(
        'AthlinksUrl'   => 'Varchar(250)',
        'FaceBookUrl'   => 'Varchar(250)',
        'FlickrUrl'     => 'Varchar(250)',
        'GoggleUrl'     => 'Varchar(250)',
        'InstagramUrl'  => 'Varchar(250)',
        'StravaUrl'     => 'Varchar(250)',
        'SkypeUser'     => 'Varchar(250)',
        'TwitterUrl'    => 'Varchar(250)',
        'VimeoUrl'      => 'Varchar(250)',
        'UltrasignupUrl'=> 'Varchar(250)',
        'YouTubeUrl'    => 'Varchar(250)',
    );

    public function updateCMSFields(FieldList $fields) {
        $fields->addFieldToTab("Root.Main", new TextField("AthlinksUrl", "Enter the full URL of your company Athlinks page"));
        $fields->addFieldToTab("Root.Main", new TextField("FacebookUrl", "Enter the full URL of your company Facebook page"));
        $fields->addFieldToTab("Root.Main", new TextField("FlickrUrl", "Enter the full URL of your company Flickr page"));
        $fields->addFieldToTab("Root.Main", new TextField("GoogleUrl", "Enter the full URL of your company Google page"));
        $fields->addFieldToTab("Root.Main", new TextField("InstagramUrl", "Enter the full URL of your company Instagram page"));
        $fields->addFieldToTab("Root.Main", new TextField("StravaUrl", "Enter the full URL of your company Strava page"));
        $fields->addFieldToTab("Root.Main", new TextField("SkypeUser", "Enter your company Skype username"));
        $fields->addFieldToTab("Root.Main", new TextField("TwitterUrl", "Enter the full URL of your company Twitter page"));
        $fields->addFieldToTab("Root.Main", new TextField("VimeoUrl", "Enter the full URL of your company Vimeo page"));
        $fields->addFieldToTab("Root.Main", new TextField("UltrasignupUrl", "Enter the full URL of your company Ultrasignup page"));
        $fields->addFieldToTab("Root.Main", new TextField("YoutubeUrl", "Enter the full URL of your company YouTube page"));
    }
}