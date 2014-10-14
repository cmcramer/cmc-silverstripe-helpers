<?php
/**
 * 
 * @author cmc
 * 
 * @todo add translate if DateTime doesn't translate automatically based on location
 *
 */
class CmcDateHelper {
	
	private $cmcdate; //DateTime
	private $dateWeek; //String
	private $weekStartDate 	= null; //DateTime
	private $weekEndDate	= null; //DateTime
	private $sameWeekMonths	= null; //Boolean
	private $sameWeekYears	= null;
	
	private static $contMark = ' - ';
	
	public function __construct($strDate='') {
		$this->cmcdate = new DateTime($strDate); //will set date to now if no date string
	}
	
	public function YearLabel() {
		return $this->cmcdate->format('Y');
	}
	
	public function MonthYearLabel($sep=' ') {
		return $this->cmcdate->format("F{$sep}Y");
	}
	
	public function ShortMonthYearLabel($sep=' ') {
		return $this->cmcdate->format("M{$sep}Y");
	}
	

	public function DayMonthYearLabel($sep=' ') {
		return $this->cmcdate->format("j{$sep}F{$sep}Y");
	}
	
	public function DayShortMonthYearLabel($sep=' ') {
		return $this->cmcdate->format("j{$sep}M{$sep}Y");
	}
	
	public function WeekLabel($sep=' ') {
		//Year and Month Same
		if ($this->isSameWeekYears() && $this->isSameWeekMonths()) {
			return $this->getWeekStartDate()->format('j') .self::$contMark.
					$this->getWeekEndDate()->format("j{$sep}F{$sep}Y");
		//Only Year same
		} elseif ($this->isSameWeekYears()) { 
			return $this->getWeekStartDate()->format("j{$sep}F") .self::$contMark.
					$this->getWeekEndDate()->format("j{$sep}F{$sep}Y");
		}
		
		//Month and Year different
		return $this->getWeekStartDate()->format("j{$sep}F{$sep}Y") .self::$contMark.
				$this->getWeekEndDate()->format("j{$sep}F{$sep}Y");
		
	}	
	
	public function WeekShortMonthLabel($sep=' ') {
		//Year and Month Same
		if ($this->isSameWeekYears() && $this->isSameWeekMonths()) {
			return $this->getWeekStartDate()->format('j') .self::$contMark.
					$this->getWeekEndDate()->format("j{$sep}M{$sep}Y");
		//Only Year same
		} elseif ($this->isSameWeekYears()) { 
			return $this->getWeekStartDate()->format("j{$sep}M") .self::$contMark.
					$this->getWeekEndDate()->format("j{$sep}M{$sep}Y");
		}
		
		//Month and Year different
		return $this->getWeekStartDate()->format("j{$sep}M{$sep}Y") .self::$contMark.
				$this->getWeekEndDate()->format("j{$sep}M{$sep}Y");
		
	}
	
	//private functions used to determine Week string
	//more lazy instantiation
	private function isSameWeekMonths() {
		//don't have to check year because range only spans one week.
		if ( $this->sameWeekMonths === null ) {
			if ($this->getWeekStartDate()->format('M') == $this->getWeekEndDate()->format('M')) {
				$this->sameWeekMonths = true;
			} else {
				$this->sameWeekMonths = false;
			}
		}
		return $this->sameWeekMonths;
	}

	private function isSameWeekYears() {
		//don't have to check year because range only spans one week.
		if ( $this->sameWeekYears === null ) {
			if ($this->getWeekStartDate()->format('Y') == $this->getWeekEndDate()->format('Y')) {
				$this->sameWeekYears = true;
			} else {
				$this->sameWeekYears = false;
			}
		}
		return $this->sameWeekYears;
	}
	
	

	//week, start and end of week lazily instantiated
	private function getDateWeek() {
		if ( $this->dateWeek === null ) {
			$this->dateWeek = $this->cmcdate->format("w");
			//Debug::show($this->dateWeek);
		}
		return $this->dateWeek;
	}
	
	private function getWeekStartDate() {
		if ( $this->weekStartDate === null ) {
			$numDateWeek = $this->getDateWeek();
			$this->weekStartDate = clone $this->cmcdate;
			$this->weekStartDate->modify("-".$this->getDateWeek()." days");
			//Debug::show($this->weekStartDate);
		}
		return $this->weekStartDate;
	}
	
	private function getWeekEndDate() {
		if ( $this->weekEndDate === null ) {
			$this->weekEndDate = clone $this->getWeekStartDate();
			$this->weekEndDate->modify("+6 days");
			//Debug::show($this->weekEndDate);
		}
		return $this->weekEndDate;
	}
	
	
		

	
}