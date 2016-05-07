<?php
class CmcListItem extends DataObject {

    private static $singular_name = 'List Item';
    private static $plural_name = 'List Items';
    
    private static $db = array(
        'ItemTitle'         => 'Text',
        'ItemContent'       => 'HTMLText',
        'ItemOrder'         => 'Int',
        'StartNewSection'   => 'CmcBoolean',
        'Hide'              => 'CmcBoolean',
    );
        
    private static $has_one = array(
        'ItemUrl'   => 'Link',
        'ListPage'  => 'Page',  
    );
    
    private static $summary_fields = array(
        'ItemTitleChopped'          => 'ItemTitle',
        'ItemContentChopped'        => 'ItemContent',
        'StartNewSection.NiceCMS'   => 'New Section',
        'Hide.NiceCMS'              => 'Hidden',  
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
        $fields->removeByName('ItemUrlID');
        $fields->removeByName('Hide');
        $fields->addFieldToTab('Root.Main', new CheckboxField('Hide', 'Hide from public pages'));
        $fields->addFieldToTab('Root.Main', new NumericField('ItemOrder', 'Order'), 'Hide');
        $fields->addFieldToTab('Root.Main', new HtmlEditorField('ItemContent','Content'), 'ItemOrder');
        $fields->addFieldToTab('Root.Main', new TextField('ItemTitle', 'Title'), 'ItemContent');
        
        $linkField = new LinkField('ItemUrlID', 'ItemLink');
        $linkField->setDescription('Makes Title/Thumbnail clickable in most templates.');
        $fields->addFieldToTab('Root.Main', $linkField, 'ItemContent');
        $fields->addFieldToTab('Root.Main', new CheckboxField('StartNewSection', 'Starts new section'), 'ItemContent');
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
    
    //should be built in, but can't find it.
    ///Based on public function singular_name() in DataObject
	//Has to be copied to derived class to grab private property
    public static function getSingularName() {
         if(!$name = static::$singular_name) {
             $name = ucwords(trim(strtolower(preg_replace('/_?([A-Z])/', ' $1', static::getClassName()))));
         }
         return $name;
    }
    
    public function NamedAnchor() {
        return strtolower(CmcStringHelper::alphanumeric($this->ItemTitleChopped(32)));
    }
    

}