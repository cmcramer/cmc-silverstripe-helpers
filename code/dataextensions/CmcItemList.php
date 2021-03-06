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
class CmcItemList extends DataExtension {


	private static $singular_name = 'Page with Item List (Block or Expand/Collapse)';
	private static $plural_name = 'Page with Item List (Block or Expand/Collapse)';
	
	protected static $_default_item_name = 'Item';
	
	
	private static $db = array(
	    'ListTitle'            => 'Text',
	    'ListNotes'            => 'HTMLText',
	    'ExpandCollapseLabel'  => 'Text',
	    'ListItemName'         => 'Text',
	    'ItemsHaveImages'      => 'CmcBoolean',
        'ThumbnailWidth'       => 'Int',
        'ThumbnailHeight'      => 'Int',
	    'ThumbnailsOnRight'    => 'CmcBoolean', 
	    'TopAnchorMenu'        => 'CmcBoolean',
	    'BottomAnchorMenu'     => 'CmcBoolean',
	);
	
	private static $has_many = array(
	         'ListItems'    => 'CmcListItem',
	);
	

	private static $defaults = array(
	    'ThumbnailWidth'    => 120,
	    'ThumbnailHeight'   => 120,
	);
	
	
	
	public function updateCMSFields(FieldList $fields) {
	    
        // Create a default configuration for the new GridField, allowing record editing
        $listGridConfig = GridFieldConfig_RelationEditor::create(50);
        $listGridConfig->addComponent(new GridFieldSortableRows('ItemOrder'));
        $listGridConfig->getComponentByType('GridFieldAddNewButton')->setButtonName("Add {$this->_getAddButtonLabel()}");
        // Create a gridfield to hold the faqs relationship
        $listItemsField = new GridField(
        		'ListItems', // Field name
        		$this->_tabName(), // Field title
        		$this->owner->ListItems(), // List of all related news faqs
        		$listGridConfig
        );
        //$listItemsField->getConfig()
        
		// Create a tab named "List" and add our field to it
        $fields->addFieldToTab("Root.{$this->_tabName()}", new TextField("ListTitle", "List Title"));
        $fields->addFieldToTab("Root.{$this->_tabName()}", new TextField("ListItemName", "List Item Name"));
        $fields->addFieldToTab("Root.{$this->_tabName()}", new TextField("ExpandCollapseLabel", "Expand/Collapse Label (optional)"));
        $fields->addFieldToTab("Root.{$this->_tabName()}", new CheckboxField('ItemsHaveImages', 'Items have thumbnail image'));
        $fields->addFieldToTab("Root.{$this->_tabName()}", 
                                    $thumbnailWidth = new NumericField('ThumbnailWidth', 'Thumbnail Width'));
        $fields->addFieldToTab("Root.{$this->_tabName()}", 
                                    $thumbnailHeight = new NumericField('ThumbnailHeight', 'Thumbnail Height'));
        $fields->addFieldToTab("Root.{$this->_tabName()}", 
                                    $thumbnailsOnRight = new CheckboxField('ThumbnailsOnRight', 'Thumbnails on Right'));
        $fields->addFieldToTab("Root.{$this->_tabName()}", new CheckboxField('TopAnchorMenu', 'Show Anchor Menu Above'));
        $fields->addFieldToTab("Root.{$this->_tabName()}", new CheckboxField('BottomAnchorMenu', 'Show Anchor Menu Beneath'));
		$fields->addFieldToTab("Root.{$this->_tabName()}", $listItemsField);
        $fields->addFieldToTab("Root.{$this->_tabName()}", new HtmlEditorField("ListNotes", "List Notes"));


        $thumbnailWidth->displayIf('ItemsHaveImages')->isChecked();
        $thumbnailHeight->displayIf('ItemsHaveImages')->isChecked();
        $thumbnailsOnRight->displayIf('ItemsHaveImages')->isChecked();
        
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
	
	

	public function PublicList() {
	    return $this->owner->ListItems()->filter(array(
	                                                    'Hide' => false,
	                                             ));
	}
	
	public function ListClass() {
	    return strtolower(CmcStringHelper::alphanumericWithDashes($this->_getAddButtonLabel()));
	}

	
	protected function _tabName() {
	    if ($this->owner->ListItemName && $this->owner->ListItemName != '') {
	        if (substr($this->owner->ListItemName, -1) == 'y') {
	            return substr($this->owner->ListItemName, 0, -1) . 'ies';
	        }
	        return "{$this->owner->ListItemName}s";
	    } else {
	        return 'List Items';
	    }
	}
	
	protected function _getAddButtonLabel() {
	    if ($this->owner->ListItemName && $this->owner->ListItemName != '') {
	        return $this->owner->ListItemName;
	    } else {
	        return static::$_default_item_name;
	    }
	    
	}
	


	public function onBeforeWrite() {
	    if (! $this->owner->ID) {
	        $this->owner->ThumbnailWidth = self::$defaults['ThumbnailWidth'];
	        $this->owner->ThumbnailHeight = self::$defaults['ThumbnailHeight'];
	    }
	}
	
	
}