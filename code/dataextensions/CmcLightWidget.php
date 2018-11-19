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
		<script src="//lightwidget.com/widgets/lightwidget.js"></script><iframe src="//lightwidget.com/widgets/c3c51bfeb30a58f6a24e7f17b8542a6a.html" 
		id="lightwidget_c3c51bfeb3" name="lightwidget_c3c51bfeb3"  
		scrolling="no" allowtransparency="true" class="lightwidget-widget" 
		style="width: 100%; border: 0; overflow: hidden;"></iframe>
	</div>
	<div><a href="http://www.instagram.com/craftsburyoutdoorcenter/" 
		title="Craftsbury Outdoor Center Instagram Feed">Follow us on Instagram</a></div>
	<!-- End Instagram feed -->
</div>

 *
 */
class CmcLightWidget extends DataExtension {
    private static $db = array(
        'LightWidgetTitle'      => 'Varchar(250)',
        'LightWidgetSrc'        => 'Varchar(250)',
        'LightWidgetId'         => 'Varchar(250)',
        'InstagramUsername'     => 'Varchar(250)',
        'InstagramLinkText'     => 'Varchar(250)',
        'InstagramLinkTitle'    => 'Varchar(250)',
    );
    
    public function updateCMSFields(FieldList $fields) {
        $fields->addFieldToTab("Root.LightWidget", new TextField("LightWidgetTitle", "Light Widget title"));
        $fields->addFieldToTab("Root.LightWidget", new TextField("LightWidgetSrc", "Enter the Light Widget Src after //"));
        $fields->addFieldToTab("Root.LightWidget", new TextField("LightWidgetId", "Enter the Light Widget ID"));
        
        $lightWidgetSrcField = TextField::create("LightWidgetSrc", "Enter the Light Widget Src after //")
        ->setDescription('This is the text after &lt;iframe src=&quot;// to the closing &quot;');
        
        $fields->addFieldToTab("Root.LightWidget", $lightWidgetSrcField);
    }
    
    public function Html() {
        $lightWidgetHtml = false;
        if ($this->owner->LightWidgetTitle && $this->owner->LightWidgetTitle != '' &&
            $this->owner->LightWidgetSrc && $this->owner->LightWidgetSrc != '' &&
            $this->owner->LightWidgetId && $this->owner->LightWidgetId != '' &&
            $this->owner->InstagramUsername && $this->owner->InstagramUsername != '' &&
            $this->owner->InstagramLinkText && $this->owner->InstagramLinkText != '' &&
            $this->owner->InstagramLinkTitle && $this->owner->InstagramLinkTitle != '' ) {
                
                $lightWidgetHtml = <<<EOT
                <!-- LightWidget WIDGET -->
                <div class="lightwidget-container">
                	<!-- Instagram feed --><!-- LightWidget WIDGET -->
                	<div id="feed-block">
                		<script src="//lightwidget.com/widgets/lightwidget.js"></script><iframe src="//lightwidget.com/widgets/c3c51bfeb30a58f6a24e7f17b8542a6a.html" 
                		id="lightwidget_c3c51bfeb3" name="lightwidget_c3c51bfeb3"  
                		scrolling="no" allowtransparency="true" class="lightwidget-widget" 
                		style="width: 100%; border: 0; overflow: hidden;"></iframe>
                	</div>
                	<div><a href="http://www.instagram.com/craftsburyoutdoorcenter/" 
                		title="Craftsbury Outdoor Center Instagram Feed">Follow us on Instagram</a></div>
                	<!-- End Instagram feed -->
                </div>
EOT;
            }
            
            return $lightWidgetHtml;
    }
}