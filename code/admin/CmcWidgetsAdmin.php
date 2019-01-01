<?php
class CmcWidgetAdmin extends ModelAdmin {
    private static $managed_models = array(
        'CmcLightWidget',
    );

    private static $url_segment = 'widgets';
    private static $menu_title = "Widget Admin";

    //public $showImportForm = true;

    //Remove import option
    //Will usually do this on admins accessible by content editors
    private static $model_importers = array(
        //'COCHohResult'     => 'COCHohCsvBulkLoader',
        //'COCHohCategory'   => 'COCHohCategoryCsvBulkLoader',
        //'COCSeason'        => 'COCSeasonCsvBulkLoader',
        //'COCCampSession'   => 'COCCampCsvBulkLoader',
    );

    /**
     * Have to set AllowedActions in derived class if override either of
     * these methods
     */
    private static $allowed_actions = array(
        //'ImportForm',
        'SearchForm',
    );


    /** Override ImportForm to remove EmptyBeforeImport option from all import forms
     * (non-PHPdoc)
     * @see ModelAdmin::getExportFields()
     */
    public function ImportForm() {
        $form = parent::ImportForm();
        if (is_object($form)) {
            $fields = $form->Fields();
            $fields->removeByName('EmptyBeforeImport');
            $form->setFields($fields);
        }
        return $form;
    }

}