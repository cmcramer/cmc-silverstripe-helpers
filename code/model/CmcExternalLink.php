<?php
class CmcExternalLink extends DataObject {

    private static $singular_name = 'Link';
    private static $plural_name = 'Links';
    
    //WidgetUrl
    //http://www.wunderground.com/swf/pws_mini_rf_nc.swf?station=<WeatherStation>&freq=2.5&units=english&lang=EN
    //NOAA Url
    //http://forecast.weather.gov/MapClick.php?lat=<DecLat>&lon=-<DecLong>&unit=0&lg=english&FcstType=graphical
    //NOAA UrlLabel ExtLabel
    private static $db = array(
        'Title'                 => 'Varchar(255)',
        'Description'           => 'Text',
        'Url'                   => 'Varchar(255)',
    
    );
        
    private static $has_one = array(
        'LinkList'  => 'CmcExternalLinkList',  
    );
    
    private static $summary_fields = array(
        'Title'                     => 'Link',
    );
    
    private static $default_sort = array(
        'Title',
    );
    
    
    private static $display_fields = array(
        'Title'  => 'Link'
    );

    
    
    
    
    public function LinkHtml() {
        $strHtml = <<<EOT
        <a href="{$this->Url}" title="{$this->Title}">{$this->Title}</a>
EOT;

        return $strHtml;
    }
    
    public function LinkWithDescriptionHtml() {
        $strHtml = <<<EOT
        <span class="external-link">{$this->LinkHtml()} - {$this->Description}</span>
EOT;
    
        return $strHtml;
    }
    

}