<?php
class CmcGridFieldCheckbox implements GridField_ColumnProvider {
    
    public function __construct($useToggle=true, $targetFragment='before') {
        $this->targetFragment = $targetFragment;
        $this->useToggle = $useToggle;
    }
    
    public function augmentColumns($gridField, &$columns) {
        if ( ! in_array('Select', $columns)) {
            array_unshift($columns, 'Select');
        }
    }
    
    public function getColumnsHandled($gridField) {
        return array ('Select');
    }
    
    public function getColumnContent($gridField, $record, $columnName) {
        if ($record->canView()) {
            $data = new ArrayData(array(
                'ID'    => $record->ID,
            ));
        }
        //This may need to changed
        return $data->renderWith('CmcGridFieldCheckbox');
    }
    
    public function getColumnAttributes($gridField, $record, $columnName) {
        return array('class' => 'col-select action');
    }
    
    public function getColumnMetadata($gridField, $columnName) {
        return array('title' => 'Select');
    }
    
}