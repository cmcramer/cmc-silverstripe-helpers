<?php
class CmcListItem extends DataObject {

    private static $singular_name = 'List Item';
    private static $plural_name = 'List Items';
    
    private static $db = array(
        'ItemTitle'     => 'Text',
        'ItemContent'   => 'HTMLText',
        'ItemOrder'     => 'Int',
        'Hide'      => 'CmcBoolean',
    );
        
    private static $has_one = array(
        'Page'  => 'Page',  
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
        $fields->removeByName('ListPageID');
        $fields->removeByName('ItemTitle');
        $fields->removeByName('ItemContent');
        $fields->removeByName('ItemOrder');
        $fields->removeByName('Hide');
        $fields->addFieldToTab('Root.Main', new CheckboxField('Hide', 'Hide from public pages'));
        $fields->addFieldToTab('Root.Main', new NumericField('ItemOrder', 'Order'), 'Hide');
        $fields->addFieldToTab('Root.Main', new HtmlEditorField('ItemContent','Content'), 'ItemOrder');
        $fields->addFieldToTab('Root.Main', new TextField('ItemTitle', 'Title'), 'ItemContent');
        return $fields;
    }
    
    
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