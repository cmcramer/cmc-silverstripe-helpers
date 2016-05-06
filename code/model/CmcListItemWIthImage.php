<?php
class CmcListItemWithImage extends CmcListItem {

    private static $singular_name = 'List Item with Image';
    private static $plural_name = 'List Items with Image';
    
    private static $db = array(
    );
    
    private static $has_one = array(
        'Image'     => 'Image',
    );
    
    private static $summary_fields = array(
        'Image.CMSThumbnail'    => 'Image',
        'ItemTitleChopped'      => 'ItemTitle',
        'ItemContentChopped'    => 'ItemContent',
        'Hide.NiceCMS'          => 'Hidden',  
    );

//     public function getCMSFields() {
//         $fields = parent::getCMSFields();
//         $fields->removeByName('ThumbnailWidth');
//         $fields->removeByName('ThumbnailHeight');
//         $fields->addFieldToTab('Root.Main', new NumericField('ThumbnailWidth', 'Thumbnail Width'), 'ItemTitle');
//         $fields->addFieldToTab('Root.Main', new NumericField('ThumbnailHeight', 'Thumbnail Height'), 'ItemTitle');
//         return $fields;
//     }

}