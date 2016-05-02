<?php
/**
 * 
 * @author cmc
 * 
 * Expandable FAQ List
 * 
 */
class CmcFaqList extends DataExtension {


	private static $singular_name = 'FAQ List';
	private static $plural_name = 'FAQ Lists';
	
	private static $db = array(
	    'ListTitle' => 'Text',
	);
	
	private static $has_many = array(
	         'Faqs'    => 'CmcFaq',
	);
	
	
	public function updateCMSFields(FieldList $fields) {
	    
        // Create a default configuration for the new GridField, allowing record editing
        $faqGridConfig = GridFieldConfig_RelationEditor::create();
        $faqGridConfig->addComponent(new GridFieldSortableRows('FaqOrder'));
        
        // Create a gridfield to hold the faqs relationship
        $faqsField = new GridField(
        		'Faqs', // Field name
        		'FAQs', // Field title
        		$this->owner->Faqs(), // List of all related news faqs
        		$faqGridConfig
        );
		// Create a tab named "Images" and add our field to it
        $fields->addFieldToTab("Root.FAQ", new TextField("ListTitle", "List Title"));
		$fields->addFieldToTab('Root.FAQ', $faqsField);
		
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