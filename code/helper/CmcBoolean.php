<?php
class CmcBoolean extends Boolean {

    public function __construct($name = null, $defaultVal = 0) {
        Requirements::css(CMC_HELPER_MODULE_DIR.'/css/cmcboolean.css');
        Requirements::themedCSS("cmcboolean");
        parent::__construct($name);
    }

    public function NiceCMS() {
        if ($this->value) {
        	$obj = HTMLText::create();
        	$obj->setValue('<span class="cmc-boolean-completed">X</span>');
            //return '<span class="boolean-checked>&nbsp;</span>';
            return $obj; //needs to be g for javascript
        }
        return '';
    }
    

    public function YesNo() {
        return $this->Nice();
    }

    public function YesBlank() {
        if ($this->value) {
            return _t('Boolean.YESANSWER', 'Yes');
        }
        return '';
    }
    
    public function TrueFalse() {
        return $this->NiceAsBoolean();
    }

}
