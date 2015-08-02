<?php
class CmcSelectGridFieldPrintButton extends GridFieldPrintButton {

    
    
    /**
     * Override getHTMLFragments to change button label
     * 
     */
     public function getHTMLFragments($gridField) {
         $button = new GridField_FormAction(
             $gridField, 
             'print-selected', 
             _t('TableListField.PrintSelected', 'Print Selected'),
             'print-selected', 
             null
         );
 
         $button->setAttribute('data-icon', 'grid_print');
         $button->addExtraClass('gridfield-button-print');
 
         return array(
             $this->targetFragment => '<p class="grid-print-button">' . $button->Field() . '</p>', 
         );
     }
    

    /**
     * Override generatePrintData to get All rows, then skip any not selected
     * 
     * Doesn't seem to be hitting this function, tried multiple debug statements, 
     * Also tried outputting Debug info to printed data and nothing is working.
     * 
     * It is grapping all data from getList rather getManipulatedList in Parent function
     */
    public function generatePrintData(GridField $gridField) {
        $printColumns = $this->getPrintColumnsForGridField($gridField);
        
        $header = null;

        if($this->printHasHeader) {
            $header = new ArrayList();

            foreach($printColumns as $field => $label){
                $header->push(new ArrayData(array(
                    "CellString" => $label,
                )));
            }
        }
        
        $items = $gridField->getList();
        $itemRows = new ArrayList();

        foreach($items as $item) {
            
            if($item->Selected == true) {
                $itemRow = new ArrayList();
            
                foreach($printColumns as $field => $label) {
                    $value = $gridField->getDataFieldValue($item, $field);
    
                    if($item->escapeTypeForField($field) != 'xml') {
                        $value = Convert::raw2xml($value);
                    }
    
                    $itemRow->push(new ArrayData(array(
                        "CellString" => $value,
                    )));
                }
                
                $itemRows->push(new ArrayData(array(
                    "ItemRow" => $itemRow
                )));
            }
            
            if ($item->hasMethod('destroy')) {
                $item->destroy();
            }
        }

        $ret = new ArrayData(array(
            "Title" => $this->getTitle($gridField),
            "Header" => $header,
            "ItemRows" => $itemRows,
            "Datetime" => SS_Datetime::now(),
            "Member" => Member::currentUser(),
        ));
        
        return $ret;
    }
    
    
    /**
     * Override these methods so there action is different than Print All Button
     * 
     * Change action in new GridField_FormAction in getHTMLFragments
     */


    /**
     * Print is an action button.
     *
     * @param GridField
     *
     * @return array
     */
    public function getActions($gridField) {
        return array('print-selected');
    }
    
    /**
     * Handle the print action.
     *
     * @param GridField
     * @param string
     * @param array
     * @param array
     */
    public function handleAction(GridField $gridField, $actionName, $arguments, $data) {
        if($actionName == 'print-selected') {
            return $this->handlePrint($gridField);
        }
    }
    
    /**
     * Print is accessible via the url
     *
     * @param GridField
     * @return array
     */
    public function getURLHandlers($gridField) {
        return array(
            'print-selected' => 'handlePrint',
        );
    }
}