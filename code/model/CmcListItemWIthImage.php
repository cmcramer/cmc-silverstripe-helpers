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


}