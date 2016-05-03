<?php
class CmcFaq extends CmcListItem {

    private static $singular_name = 'FAQ';
    private static $plural_name = 'FAQs';
    
//     private static $db = array(
//         'Question' => 'Text',
//         'Answer'   => 'HTMLText',
//         'FaqOrder' => 'Int',
//         'Hide'  => 'CmcBoolean',
//     );
        
//     private static $has_one = array(
//         'FaqPage'  => 'Page',  
//     );
    
    private static $summary_fields = array(
        'ItemTitleChopped' => 'Question',
        'ItemContentChopped'   => 'Answer',  
        'Hide.NiceCMS' => 'Hidden',
    );
    
//     private static $default_sort = array(
//         'FaqOrder',
//     );
    
    public function getCMSFields() {
        $fields = parent::getCMSFields();
        $fields->removeByName('ItemTitle');
        $fields->removeByName('ItemContent');
        $fields->addFieldToTab('Root.Main', new HtmlEditorField('ItemContent','Answer'), 'ItemOrder');
        $fields->addFieldToTab('Root.Main', new TextField('ItemTitle', 'Question'), 'ItemContent');
        return $fields;
    }
    
    
//     private static $display_fields = array(
//         'Question'  => 'Link'
//     );

//     public function getTitle() {
//         return $this->QuestionChopped();
//     }

    
//     public function QuestionChopped($maxChars=50) {
//         return CmcHtmlTextHelper::NoHtmlChop($this->Question, $maxChars);
//     }
    
//     public function AnswerChopped($maxChars=50) {
//         return CmcHtmlTextHelper::NoHtmlChop($this->Answer, $maxChars);
//     }
    


}