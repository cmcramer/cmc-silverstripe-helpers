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


	protected static $_default_item_name = 'Item';

	//have to repeat fields in extended dataextension
	private static $db = array(
	    'ListTitle'            => 'Text',
	    'ListNotes'            => 'HTMLText',
	    'ExpandCollapseLabel'  => 'Text',
	    'ListItemName'         => 'Text',
        'ThumbnailWidth'       => 'Int',
        'ThumbnailHeight'      => 'Int',
	    'ThumbnailsOnRight'    => 'CmcBoolean', 
	    'TopAnchorMenu'        => 'CmcBoolean',
	    'BottomAnchorMenu'     => 'CmcBoolean',
	);

	
	private static $has_many = array(
	         'ListItems'    => 'CmcListItemWithImage',
	);
	
	private static $defaults = array(
	       'ThumbnailWidth'    => 120,
	       'ThumbnailHeight'   => 120,
	);
	
	
	public function updateCMSFields(FieldList $fields) {
	    
	    self::populateDefaults();
        // Create a default configuration for the new GridField, allowing record editing
        $listGridConfig = GridFieldConfig_RelationEditor::create();
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
        $fields->addFieldToTab("Root.{$this->_tabName()}", new NumericField('ThumbnailWidth', 'Thumbnail Width'));
        $fields->addFieldToTab("Root.{$this->_tabName()}", new NumericField('ThumbnailHeight', 'Thumbnail Height'));
        $fields->addFieldToTab("Root.{$this->_tabName()}", new CheckboxField('ThumbnailsOnRight', 'Thumbnails on Right'));
        $fields->addFieldToTab("Root.{$this->_tabName()}", new CheckboxField('TopAnchorMenu', 'Show Anchor Menu Above'));
        $fields->addFieldToTab("Root.{$this->_tabName()}", new CheckboxField('BottomAnchorMenu', 'Show Anchor Menu Beneath'));
		$fields->addFieldToTab("Root.{$this->_tabName()}", $listItemsField);
        $fields->addFieldToTab("Root.{$this->_tabName()}", new HtmlEditorField("ListNotes", "List Notes"));
        
        return $fields;
	}
	

	
	public function onBeforeWrite() {
	    if (! $this->owner->ID) {
	        $this->owner->ThumbnailWidth = self::$defaults['ThumbnailWidth'];
	        $this->owner->ThumbnailHeight = self::$defaults['ThumbnailHeight'];
	    }
	}
	
}