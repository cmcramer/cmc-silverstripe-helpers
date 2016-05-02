<?php
class CmcExpandCollapseListItem extends DataObject {

    private static $singular_name = 'FAQ';
    private static $plural_name = 'FAQs';
    
    private static $db = array(
        'ItemTitle' => 'Text',
        'ItemContent'   => 'HTMLText',
        'ExpandCollapseListItemOrder' => 'Int',
    );
        
    private static $has_one = array(
        'ListItemPage'  => 'Page',  
    );
    
    private static $summary_fields = array(
        'ItemTitleChopped'          => 'ItemTitle',
        'ItemContentChopped'    => 'ItemContent',  
    );
    
    private static $default_sort = array(
        'ExpandCollapseListItemOrder',
    );
    
    public function getCMSFields() {
        $fields = parent::getCMSFields();
        $fields->removeByName('ListPageID');
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