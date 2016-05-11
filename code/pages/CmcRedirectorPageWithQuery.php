<?php
/**
 * 
 * @author cmc
 * 
 * Adds field for parameters or query string to internal page link
 *
 * Add extension to RedirectorPage in mysite/_config/config.yml
 * 
 */
class CmcRedirectorPageWithQuery extends RedirectorPage {


	private static $singular_name = 'Redirector Page with Route or Query';
	private static $plural_name = 'Redirector Pages with Route or Query';
	
	private static $description = 'Redirects to a different page. Option to add query or route to internal page.';
	

	private static $db = array(
	    'QueryString'          => 'Text',
	);
	
	public function __construct($name = null, $defaultVal = 0) {
	    Requirements::css(CMC_HELPER_MODULE_DIR.'/css/cmcrediretcorpagewithquery.css');
	    parent::__construct($name);
	}
	
	public function getCMSFields() {
	    $fields = parent::getCMSFields();
	    $fields->removeByName('LinkToID');
	    $fields->removeByName('ExternalURL');
	    
	    $internalPageField = new DisplayLogicWrapper(new TreeDropdownField(
	                               'LinkToID', 'Page on this website', 'SiteTree'));
	    $internalPageField->displayIf("RedirectionType")->isEqualTo("Internal");
	    
	    
	    $fields->addFieldToTab('Root.Main', $internalPageField);
	    $fields->addFieldsToTab('Root.Main', 
	           $queryField = new TextField('QueryString', 'Route or Query String'));
	    
	    $queryField->displayIf("RedirectionType")->isEqualTo("Internal");
	    

	    $fields->addFieldsToTab('Root.Main',
	        $externalUrlField = new TextField('ExternalURL', 'Other website URL'));
	     
	    $externalUrlField->displayIf("RedirectionType")->isEqualTo("External");
	    
	    
	    return $fields;
	    
	}
	
	
	/**
	 * Overide Link function
	 */
    public function redirectionLink() {
        $link = parent::redirectionLink();
        if($this->RedirectionType == 'Internal' && $this->QueryString && $this->QueryString != '') {
            return $link.$this->QueryString;
        }
        return $link;
    }
	
    
	
}


class CmcRedirectorPageWithQuery_Controller extends RedirectorPage_Controller {
    
}