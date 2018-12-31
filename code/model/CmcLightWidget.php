<?php
class CmcLightWidget extends DataObject {

    private static $singular_name = 'LightWidget for Instagram';
    private static $plural_name = 'LightWidgets for Instagram';

    //Get ID and upgrade widget at https://lightwidget.com
    //If widget not upgraded won't work with https
    private static $db = array(
        'WidgetTitle'           => 'Varchar(255)',
        'WidgetId'              => 'Varchar(255)',
        'InstagramFeedTitle'    => 'Varchar(255)',
        'InstagramUser'         => 'Varchar(255)',
    );
        
    private static $belongs_to = array(
        'Page'  => 'Page',    
    );
    
    private static $summary_fields = array(
        'WidgetTitle'                     => 'Weather Widget',
    );
    
    private static $default_sort = array(
        'WidgetTitle',
    );
    
    
    private static $display_fields = array(
        'WidgetTitle'  => 'Weather Widget',
        'InstagramUser' => 'Instagram User'
    );

    private static $defaults = array(
    );
    
    public function getTitle() {
        return $this->WidgetTitle;
    }


    public function WidgetHtml() {
        if ($this->Template == '') {
            return $this->renderWith('LightWidget');
        }
        return $this->renderWith($this->Template);
    }


}