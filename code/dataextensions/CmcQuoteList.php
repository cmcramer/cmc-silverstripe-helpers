<?php
/**
 * 
 * @author cmc
 * 
 * Expandable Quote List - Shares code with CmcItemList
 *
 * @see if client wants images, sections, urls see CmcItemList, CmcListItem
 * 
 */
class CmcQuoteList extends DataExtension {


	private static $singular_name = 'Quote List';
	private static $plural_name = 'Quote Lists';
	
	
	private static $db = array(
	    'ListTitle'            => 'Text',
	    'ListNotes'            => 'HTMLText',
	);
	
	private static $has_many = array(
	         'Quotes'    => 'CmcQuote',
	);
	

	
	
	public function updateCMSFields(FieldList $fields) {
	    
        // Create a default configuration for the new GridField, allowing record editing
        $faqGridConfig = GridFieldConfig_RelationEditor::create(50);
        $faqGridConfig->addComponent(new GridFieldSortableRows('ItemOrder'));
        
        // Create a gridfield to hold the faqs relationship
        $faqsField = new GridField(
        		'Quotes', // Field name
        		'Quotes', // Field title
        		$this->owner->Quotes(), // List of all related news faqs
        		$faqGridConfig
        );
		// Create a tab named "Images" and add our field to it
        $fields->addFieldToTab("Root.Quotes", new TextField("ListTitle", "List Title"));
		$fields->addFieldToTab('Root.Quotes', $faqsField);
        $fields->addFieldToTab("Root.Quotes", new HtmlEditorField("ListNotes", "List Notes"));
		
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
	}
	

	public function PublicQuote() {
	    return $this->owner->Quotes()->filter(array(
	                                           'Hide' => false,
	                                        ));
	}
	
}