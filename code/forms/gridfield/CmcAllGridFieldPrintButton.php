<?php
class CmcAllGridFieldPrintButton extends GridFieldPrintButton {
    
    /**
     * Override getHTMLFragments to change button label
     * 
     */
     public function getHTMLFragments($gridField) {
         $button = new GridField_FormAction(
             $gridField, 
             'print', 
             _t('TableListField.PrintAll', 'Print All'),
             'print', 
             null
         );
 
         $button->setAttribute('data-icon', 'grid_print');
         $button->addExtraClass('gridfield-button-print');
 
         return array(
             $this->targetFragment => '<p class="grid-print-button">' . $button->Field() . '</p>', 
         );
     }

    /**
     * Override generatePrintData to get All rows
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

    
}