<?php
class CmcSeason extends DataObject {
    public static $singular_name = 'Season';
    public static $plural_name = 'Seasons';


    private static $db = array(
        'Title' 		=> 'Varchar(100)',
        'StartDate'     => 'Date',
        'EndDate'     	=> 'Date',
    );

     
    private static $default_sort = array (
        'StartDate DESC',
    );


    public static $summary_fields = array(
        'Title'			=> 'Season',
        'StartDate' 	=> 'Start',
        'EndDate' 		=> 'End',
    );


    public function StartDate() {
        if ($this->StartDate != '') {
            return $this->StartDate;
        } 
        return '';
    }
    
    public function EndDate() {
        
        // if EndDate set and greater than 
        if ($this->EndDate != '' && 
            $this->EndDate > $this->StartDate()) {
            return $this->EndDate;
        
        //if EndDate not set, but StartDate is set return today
        } elseif ($this->StartDate() != '') {
            return date("Y-m-d");
        }
        //if neither EndDate nor StartDate set return null
        return '';
    }


     

}