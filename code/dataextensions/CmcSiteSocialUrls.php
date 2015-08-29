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
 *  @todo change to offer dropdown with list of Social Types and field for URL with plus button to add as needed
 *
 */
class CmcSiteSocialUrls extends DataExtension {
    private static $db = array(
        'AthlinksUrl'   => 'Varchar(250)',
        'BloggerUrl'    => 'Varchar(250)',
        'FaceBookUrl'   => 'Varchar(250)',
        'FlickrUrl'     => 'Varchar(250)',
        'GoggleUrl'     => 'Varchar(250)',
        'InstagramUrl'  => 'Varchar(250)',
        'LinkedInUrl'   => 'Varchar(250)',
        'PinterestUrl'  => 'Varchar(250)',
        'SkypeUser'     => 'Varchar(250)',
        'SoundcloudUrl' => 'Varchar(250)',
        'SpotifyUrl'    => 'Varchar(250)',
        'StravaUrl'     => 'Varchar(250)',
        'TumblrUrl'     => 'Varchar(250)',
        'TwitterUrl'    => 'Varchar(250)',
        'VimeoUrl'      => 'Varchar(250)',
        'UltrasignupUrl'=> 'Varchar(250)',
        'WordpressUrl'  => 'Varchar(250)',
        'YouTubeUrl'    => 'Varchar(250)',
    );
    

    public function updateCMSFields(FieldList $fields) {
        $fields->addFieldToTab("Root.SiteSocial", new TextField("AthlinksUrl", "Enter the full URL of your company Athlinks"));
        $fields->addFieldToTab("Root.SiteSocial", new TextField("BloggerUrl", "Enter the full URL of your company Blogger blog"));
        $fields->addFieldToTab("Root.SiteSocial", new TextField("FaceBookUrl", "Enter the full URL of your company Facebook"));
        $fields->addFieldToTab("Root.SiteSocial", new TextField("FlickrUrl", "Enter the full URL of your company Flickr"));
        $fields->addFieldToTab("Root.SiteSocial", new TextField("GoogleUrl", "Enter the full URL of your company Google +"));
        $fields->addFieldToTab("Root.SiteSocial", new TextField("InstagramUrl", "Enter the full URL of your company Instagram"));
        $fields->addFieldToTab("Root.SiteSocial", new TextField("LinkedInUrl", "Enter the full URL of your company LinkedIn"));
        $fields->addFieldToTab("Root.SiteSocial", new TextField("PinterestUrl", "Enter the full URL of your company Pinterest"));
        $fields->addFieldToTab("Root.SiteSocial", new TextField("SkypeUser", "Enter your company Skype username"));
        $fields->addFieldToTab("Root.SiteSocial", new TextField("SoundcloudUrl", "Enter the full URL of your company Soundcloud"));
        $fields->addFieldToTab("Root.SiteSocial", new TextField("SpotifyUrl", "Enter the full URL of your company Spotify"));
        $fields->addFieldToTab("Root.SiteSocial", new TextField("StravaUrl", "Enter the full URL of your company Strava"));
        $fields->addFieldToTab("Root.SiteSocial", new TextField("TumblrUrl", "Enter the full URL of your company Tumblr"));
        $fields->addFieldToTab("Root.SiteSocial", new TextField("TwitterUrl", "Enter the full URL of your company Twitter"));
        $fields->addFieldToTab("Root.SiteSocial", new TextField("VimeoUrl", "Enter the full URL of your company Vimeo"));
        $fields->addFieldToTab("Root.SiteSocial", new TextField("UltrasignupUrl", "Enter the full URL of your company Ultrasignup"));
        $fields->addFieldToTab("Root.SiteSocial", new TextField("WordpressUrl", "Enter the full URL of your company Wordpress blog"));
        $fields->addFieldToTab("Root.SiteSocial", new TextField("YouTubeUrl", "Enter the full URL of your company YouTube"));
    }
    
    
    public function CmcSiteSocialBlock() {
        $htmlSocialBlock = '';
        
        foreach (self::$db as $fieldName => $dataType) {
            if (isset($this->owner->$fieldName) && $this->owner->$fieldName != '') {
                $htmlSocialBlock .= '<span class="social-icon">'.$this->CmcSocialIconUrl($fieldName).'</span>';
            }
        }
        
        if ($htmlSocialBlock != '') {
            $htmlSocialBlock = '<div class="social-icon-block">'.$htmlSocialBlock.'</div>';
        }
          
        return $htmlSocialBlock;
    }
    
    
    public function CmcSocialIconUrl($fieldName) {
        $htmlSocialUrl = <<<EOT
        <a href="{$this->owner->$fieldName}" title="{$this->CmcSocialName($fieldName)}"><img src="{$this->CmcSocialIcon($fieldName)}" alt="{$this->CmcSocialName($fieldName)}"></img></a>
EOT;
        return $htmlSocialUrl;
    }
    
    public function CmcSocialIcon($fieldName) {
        return HELPER_MODULE_DIR.'/images/'.strtolower($this->CmcSocialName($fieldName)) . ".png";
    }
    
    public function CmcSocialName($fieldName) {
        $arrSearch = array("Url", "User");
        return str_replace($arrSearch, "", $fieldName);
    }
    
    
}