<?php
class CmcSelectGridFieldExportButton extends GridFieldExportButton {
    
    /**
     * Override getHTMLFragments to change button label
     * 
     */
     public function getHTMLFragments($gridField) {
         $button = new GridField_FormAction(
             $gridField,
             'export-selected',
             _t('TableListField.CSVEXPORTSelected', 'Export Selected to CSV'),
             'export-selected',
             null
         );
         $button->setAttribute('data-icon', 'download-csv');
         $button->addExtraClass('no-ajax');
         return array(
             $this->targetFragment => '<p class="grid-csv-button">' . $button->Field() . '</p>',
         );
     }

    /**
     * Override generateExportData to get All rows
     */
     public function generateExportFileData($gridField) {
         $separator = $this->csvSeparator;
         $csvColumns = ($this->exportColumns)
             ? $this->exportColumns
             : singleton($gridField->getModelClass())->summaryFields();
         $fileData = '';
         $columnData = array();
         $fieldItems = new ArrayList();
 
         if($this->csvHasHeader) {
             $headers = array();
 
             // determine the CSV headers. If a field is callable (e.g. anonymous function) then use the
             // source name as the header instead
             foreach($csvColumns as $columnSource => $columnHeader) {
                 $headers[] = (!is_string($columnHeader) && is_callable($columnHeader)) ? $columnSource : $columnHeader;
             }
 
             $fileData .= "\"" . implode("\"{$separator}\"", array_values($headers)) . "\"";
             $fileData .= "\n";
         }
         
         //Remove GridFieldPaginator as we're going to export the entire list.
         $gridField->getConfig()->removeComponentsByType('GridFieldPaginator');
         
         $items = $gridField->getList();
 
         // @todo should GridFieldComponents change behaviour based on whether others are available in the config?
         foreach($gridField->getConfig()->getComponents() as $component){
             if($component instanceof GridFieldFilterHeader || $component instanceof GridFieldSortableHeader) {
                 $items = $component->getManipulatedData($gridField, $items);
             }
         }
 
         foreach($items->limit(null) as $item) {
             
             if( ( !$item->hasMethod('canView') || $item->canView() ) && 
                    $item->Selected == true) {
                 $columnData = array();
 
                 foreach($csvColumns as $columnSource => $columnHeader) {
                     if(!is_string($columnHeader) && is_callable($columnHeader)) {
                         if($item->hasMethod($columnSource)) {
                             $relObj = $item->{$columnSource}();
                         } else {
                             $relObj = $item->relObject($columnSource);
                         }
 
                         $value = $columnHeader($relObj);
                     } else {
                         $value = $gridField->getDataFieldValue($item, $columnSource);
 
                         if(!$value) {
                             $value = $gridField->getDataFieldValue($item, $columnHeader);
                         }
                     }
 
                     $value = str_replace(array("\r", "\n"), "\n", $value);
                     $columnData[] = '"' . str_replace('"', '""', $value) . '"';
                 }
 
                 $fileData .= implode($separator, $columnData);
                 $fileData .= "\n";
             }
 
             if($item->hasMethod('destroy')) {
                 $item->destroy();
             }
         }
 
         return $fileData;
     }
    
    
    /**
     * Override these methods so the action is different than Print All Button
     * 
     * Change action in new GridField_FormAction in getHTMLFragments
     */


    /**
     * Export is an action button.
     *
     * @param GridField
     *
     * @return array
     */
    public function getActions($gridField) {
        return array('export-selected');
    }
    
    /**
     * Handle the export action.
     *
     * @param GridField
     * @param string
     * @param array
     * @param array
     */
    public function handleAction(GridField $gridField, $actionName, $arguments, $data) {
        if($actionName == 'export-selected') {
            return $this->handleExport($gridField);
        }
    }
    
    /**
     * Export is accessible via the url
     *
     * @param GridField
     * @return array
     */
    public function getURLHandlers($gridField) {
        return array(
            'export-selected' => 'handleExport',
        );
    }

    
}