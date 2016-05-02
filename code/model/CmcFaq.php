<?php
class CmcFaq extends DataObject {

    private static $singular_name = 'FAQ';
    private static $plural_name = 'FAQs';
    
    private static $db = array(
        'Question' => 'Text',
        'Answer'   => 'HTMLText',
        'FaqOrder' => 'Int',
    );
        
    private static $has_one = array(
        'FaqPage'  => 'Page',  
    );
    
    private static $summary_fields = array(
        'QuestionChopped' => 'Question',
        'AnswerChopped'   => 'Answer',  
    );
    
    private static $default_sort = array(
        'FaqOrder',
    );
    
    public function getCMSFields() {
        $fields = parent::getCMSFields();
        $fields->removeByName('FaqPageID');
        return $fields;
    }
    
    
//     private static $display_fields = array(
//         'Question'  => 'Link'
//     );

    public function getTitle() {
        return $this->QuestionChopped();
    }

    
    public function QuestionChopped($maxChars=50) {
        return CmcHtmlTextHelper::NoHtmlChop($this->Question, $maxChars);
    }
    
    public function AnswerChopped($maxChars=50) {
        return CmcHtmlTextHelper::NoHtmlChop($this->Answer, $maxChars);
    }
    

}