<?php
/**
 * CmcLightWidget
 *
 * @author cmc
 *
 * @see - Extensino for LightWidget embedded Instagram Feeg
 *
 * @usage -
 *  First create widget in your widget at LightWidget
 *
 *  Fields for this DataObject correspond to these parts of the code from the Twitter Widget
 *
 *  <!-- LightWidget WIDGET -->
<div id="potd" class="snow-comments">
<!-- Instagram feed --><!-- LightWidget WIDGET -->
<div id="feed-block">
<script src="//lightwidget.com/widgets/lightwidget.js"></script><iframe src="//lightwidget.com/widgets/widget-ih.html"
id="lightwidget" name="lightwidget"
scrolling="no" allowtransparency="true" class="lightwidget-widget"
style="width: 100%; border: 0; overflow: hidden;"></iframe>
</div>
<div><a href="http://www.instagram.com/instagram_user/"
title="OurkInstagram Feed">Follow us on Instagram</a></div>
<!-- End Instagram feed -->
</div>

 *
 */

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


    public function WidgetShortId() {
        return substr($this->WidgetId,0,10);
    }

}