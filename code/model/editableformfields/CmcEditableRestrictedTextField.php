<?php
/**
 * CmcEditableRestrictedTextField
 *
 * This control represents a user-defined text field in a user defined form
 * Validation fails if string contains items on restricted list
 *
 * @package userforms
 */

class CmcEditableRestrictedTextField extends EditableTextField {

	private static $singular_name = 'Restricted Text Field';

	private static $plural_name = 'Restricted Text Fields';

	private static $db = array(
	    'DisallowedText' => 'Text',
	);




	/**
	 * @return FieldList
	 */
	public function getFieldValidationOptions() {
		$fields = parent::getFieldValidationOptions();

		$fields->merge(array(
			CmcRestrictedTextField::create(
				'DisallowedText',
				_t('CmcEditableRestictedTextField.DISALLOWED', 'Disallowed Text')
			)->setDescription(_t(
				'CmcEditableRestrictedTextField.DISALLOWED_DESCRIPTION',
				'Separate strings with commas. If any strings in this list are in submitted text validation will fail. Validation is case insensitive.'
			))
		));

		return $fields;
	}
	
	/**
	 * @return TextareaField|TextField
	 */
	public function getFormField() {
		if($this->Rows > 1) {
			$field = CmcRestrictedTextareaField::create($this->Name, $this->EscapedTitle, $this->Default)
				->setFieldHolderTemplate('UserFormsField_holder')
				->setTemplate('UserFormsTextareaField')
				->setRows($this->Rows);
		} else {
			$field = CmcRestrictedTextField::create($this->Name, $this->EscapedTitle, $this->Default, $this->MaxLength)
				->setFieldHolderTemplate('UserFormsField_holder')
				->setTemplate('UserFormsField');
		}

		$field->setDisallowedText($this->DisallowedText);

		$this->doUpdateFormField($field);
        
	
	    return $field;
	}
	


}
