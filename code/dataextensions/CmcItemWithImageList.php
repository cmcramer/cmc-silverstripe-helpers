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


	//have to repeat fields in extended dataextension
	private static $db = array(
	    'ListTitle'    => 'Text',
	    'ListNotes'    => 'HTMLText',
	    'ExpandCollapseLabel'  => 'Text',
	    'ListItemName' => 'Text',
	);

	
	private static $has_many = array(
	         'ListItems'    => 'CmcListItemWithImage',
	);
	

	
	
}