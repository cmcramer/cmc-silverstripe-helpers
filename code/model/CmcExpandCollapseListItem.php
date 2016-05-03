<?php
class CmcExpandCollapseListItem extends DataObject {

    private static $singular_name = 'List Item';
    private static $plural_name = 'List Items';
    
    private static $db = array(
        'ItemTitle'     => 'Text',
        'ItemContent'   => 'HTMLText',
        'ItemOrder'     => 'Int',
        'Hide'      => 'CmcBoolean',
    );
        
    private static $has_one = array(
        'ListItemPage'  => 'Page',  
    );
    
    private static $summary_fields = array(
        'ItemTitleChopped'      => 'ItemTitle',
        'ItemContentChopped'    => 'ItemContent',
        'Hide.NiceCMS'       => 'Hidden',  
    );
    
    private static $default_sort = array(
        'ItemOrder',
    );
    
    public function getCMSFields() {
        $fields = parent::getCMSFields();
        $fields->removeByName('ListItemPageID');
        return $fields;
    }
    
    
//     private static $display_fields = array(
//         'ItemTitle'  => 'Link'
//     );

    public function getTitle() {
        return $this->ItemTitleChopped();
    }

    
    public function ItemTitleChopped($maxChars=50) {
        return CmcHtmlTextHelper::NoHtmlChop($this->ItemTitle, $maxChars);
    }
    
    public function ItemContentChopped($maxChars=50) {
        return CmcHtmlTextHelper::NoHtmlChop($this->ItemContent, $maxChars);
    }
    
    

}