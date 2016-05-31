<?php
<?php
class CmcRestrictedTextareaField extends TextareaField {

    /**
     * @var string $disallowedText
     */
    protected $disallowedText = '';
     
     
    /**
     * Returns an input field
     *
     * @param string $name
     * @param null|string $title
     * @param string $value
     * @param null|int $maxLength
     * @param string $disallowedText
     */
    public function __construct($name, $title = null, $value = '', $maxLength = null, $form = null, $disallowedText='') {
        if($disallowedText) {
            $this->setDisallowedText($disallowedText);
        }
         
        parent::__construct($name, $title, $value, $form);
    }

     
    /**
     *
     * {@inheritDoc}
     * @see TextField::validate()
     */
    public function validate($validator) {
         
        if (! parent::validate($validator)) {
            return false;
        }


        if (!is_null($this->disallowedText) && $this->disallowedText != '') {
            echo $this->Value() . '<br>';
            foreach ($this->getDisallowedTextArray() as $strDisallowed) {
                if( ! (stristr($this->Value(), trim($strDisallowed)) === false) ) {
                    $validator->validationError(
                        $this->name,
                        _t(
                            'RestrictedTextField.DISSALLOWEDTEXT',
                            'Your submission failed.'
                            ),
                        "validation"
                        );
                    return false;
                }
            }
        }

        return true;

    }
     
     
    public function setDisallowedText($csvString) {
        $this->disallowedText = $csvString;
         
        return $this;
    }
     
    public function getDisallowedText() {
        return $this->disallowedText;
    }
     
    public function getDisallowedTextArray() {
        return explode(',', $this->disallowedText);
    }

}