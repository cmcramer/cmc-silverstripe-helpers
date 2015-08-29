<?php

/**
 * CmcSiteTwitterFeed
 *
 * @author cmc
 * 
 * @see - Twitter Embedded Timeline Documentation https://dev.twitter.com/web/embedded-timelines
 *
 * @usage -
 *  First create widget in your Twitter account
 *  
 *  Fields for this DataObject correspond to these parts of the code from the Twitter Widget
 *  
 *  <a class="twitter-timeline" data-dnt="true" href="<TwitterTimelineUrl>"  
 *      data-widget-id="<TwitterWidgetId>">Tweets <TwitterFeedName></a>
 *      <script>....</script>
 *      
 *      Include "by/from" in TwitterFeedName field!!
 *  
 *      In _config/config.yml
 *
 *          SiteConfig:
 *              extensions:
 *                  - CmcSiteTwitterFeed
 *
 *      In template
 *
 *          $CmcTwitterFeed
 *
 */
class CmcSiteTwitterFeed extends DataExtension {
    public static $db = array(
        'TwitterTimelineUrl'    => 'Varchar(250)',
        'TwitterWidgetId'       => 'Varchar(250)',
        'TwitterFeedName'       => 'Varchar(250)',
    );

    public function updateCMSFields(FieldList $fields) {
        $fields->addFieldToTab("Root.Main", new TextField("TwitterTimelineUrl", "Enter the full Twitter Timeline URL"));
        $fields->addFieldToTab("Root.Main", new TextField("TwitterWidgetId", "Enter the Twitter Widget ID"));
        
        $twitterFeedNameField = TextField::create("TwitterFeedName", "Enter Twitter Feed Name (including by/from)")
            ->setDescription('Fields for this DataObject correspond to these parts of the code from the Twitter Widget<br><br>
                <code>&lt;a class="twitter-timeline" data-dnt="true" href="&laquo;TwitterTimelineUrl&raquo;"  
                data-widget-id="&laquo;TwitterWidgetId&raquo;"&gt;Tweets &laquo;TwitterFeedName&raquo;&lt;&#47;a&gt;<br>
                &lt;script&gt;....$lt;&#47;script&gt;</code>
                <br><br>Include "by&#47;from" in TwitterFeedName field!!');
        
        $fields->addFieldToTab("Root.Main", $twitterFeedNameField);
    }
    
    public function CmcTwitterFeed() {
        $twitterFeed = false;
        if ($this->owner->TwitterTimelineUrl && $this->TwitterTimelineUrl != '' &&
            $this->TwitterWidgetId && $this->TwitterWidgetId != '' && 
            $this->TwitterFeedName && $this->TwitterFeedName != '') {

                $twitterFeed = <<<EOT
                <a class="twitter-timeline" data-dnt="true" href="{$this->TwitterTimelineUrl}"  data-widget-id="{$this->TwitterWidgetId}" data-chrome="noheader">Tweets {$this->TwitterFeedName}</a>
                <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
EOT;
        }
        
        return $twitterFeed;
    }
}