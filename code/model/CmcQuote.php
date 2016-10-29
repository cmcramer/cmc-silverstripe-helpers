<?php
class CmcQuote extends CmcListItem {

    private static $singular_name = 'Quote';
    private static $plural_name = 'Quotes';
	
	protected static $_default_item_name = 'Quote';
    
     private static $db = array(
         'ShowCredit'  => 'CmcBoolean',
     );
        
//     private static $has_one = array(
//         'QuotePage'  => 'Page',  
//     );
    
    private static $summary_fields = array(
        'ItemTitleChopped' => 'Quote',
        'ItemContentChopped'   => 'Credit',  
        'Hide.NiceCMS' => 'Hidden',
    );
    
//     private static $default_sort = array(
//         'QuoteOrder',
//     );
    
    public function getCMSFields() {
        $fields = parent::getCMSFields();
        $fields->removeByName('ItemTitle');
        $fields->removeByName('ItemContent');
        $fields->removeByName('ItemUrlID');
        $fields->removeByName('StartNewSection');
        $fields->addFieldToTab('Root.Main', new HtmlEditorField('ItemContent','Credit'), 'ItemOrder');
        $fields->addFieldToTab('Root.Main', new TextField('ItemTitle', 'Quote'), 'ItemContent');
        return $fields;
    }
    


}