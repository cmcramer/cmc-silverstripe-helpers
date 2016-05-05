<?php
/**
 * 
 * @author cmc
 * 
 * List - Similar to FaqList
 * 
 * Can be expandable if set up in template used by page that uses this extension
 * 
 */
class CmcItemWithImageList extends CmcItemList {


	private static $singular_name = 'Page with Item with Image List (Block or Expand/Collapse)';
	private static $plural_name = 'Page with Item with Image List (Block or Expand/Collapse)';
	

	
	private static $has_many = array(
	         'ListItems'    => 'CmcListItemWithImage',
	);
	

	
	
	public function ToggleJsInit() {
        $themeDir = SSViewer::get_theme_folder();
	    //when add option for multiple inline html blocks will need wildcard for "href", "#inline"
	    //or multiple call
	    $strJsLoadTJK = <<<EOT
	    function addLoadEvent(func) {
		  var oldonload = window.onload;
		  if (typeof window.onload != 'function') {
		    window.onload = func;
		  } else {
		    window.onload = function() {
		      oldonload();
		      func();
		    }
		  }
		}
		addLoadEvent(TJK_ToggleDL);
EOT;
        
	    Requirements::javascript(CMC_HELPER_MODULE_DIR."/javascript/TJK_ToggleDL/TJK_ToggleDL.js");
	    Requirements::customScript($strJsLoadTJK);
	}
	
	

	public function PublicList() {
	    return $this->owner->ListItems()->filter(array(
	                                                    'Hide' => false,
	                                             ));
	}
	
	
}