<?php
/**
 * 
 * @author cmc
 * 
 * Expandable List - Similar to FaqList
 * 
 */
class CmcExpandCollapseList extends DataExtension {


	private static $singular_name = 'Expand/Collapse List';
	private static $plural_name = 'Expand/Collapse Lists';
	
	private static $db = array(
	    'ListTitle'            => 'Text',
	    'ExpandCollapseLabel'  => 'Text',
	);
	
	private static $has_many = array(
	         'ExpandCollapseListItems'    => 'CmcExpandCollapseListItem',
	);
	
	
	public function updateCMSFields(FieldList $fields) {
	    
        // Create a default configuration for the new GridField, allowing record editing
        $faqGridConfig = GridFieldConfig_RelationEditor::create();
        $faqGridConfig->addComponent(new GridFieldSortableRows('ExpandCollapseOrder'));
        
        // Create a gridfield to hold the faqs relationship
        $listItemsField = new GridField(
        		'ExpandCollapseListItems', // Field name
        		'List', // Field title
        		$this->owner->ExpandCollapses(), // List of all related news faqs
        		$faqGridConfig
        );
		// Create a tab named "Images" and add our field to it
        $fields->addFieldToTab("Root.List", new TextField("ListTitle", "List Title"));
        $fields->addFieldToTab("Root.List", new TextField("ExpandCollapseLabel", "Expand/Collapse Label"));
		$fields->addFieldToTab('Root.List', $listItemsField);
		
	}

	
	
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
// 	    $strJs = <<<EOT
// 	    addLoadEvent(TJK_ToggleDL);
// EOT;
	    //return $strJs;
	}
	
	
	
}