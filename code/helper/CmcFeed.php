<?php
//include_once(Director::getAbsFile(SAPPHIRE_DIR . '/thirdparty/simplepie/simplepie.inc'));
class CmcFeed {
	
	//public $url;  
	protected $dateFormat;
	protected $feed;
	
	
	public function __construct($strFeedUrl, $limit=10, $dateFormat="j.M.y") {
		//$this->url = $strFeedUrl;
		$this->feed = new SimplePie($strFeedUrl, 0, $limit);
		$this->dateFormat = $dateFormat;
	}
	
	public function RssItems() {
		$this->feed->init();
		$feedList = new ArrayList();
		
		if ($this->feed->get_items()) {
			$items = $this->feed->get_items();
			foreach ($items as $item) {
				$feedList->push(new ArrayData(array(
						'Title' 		=> $item->get_title(),
						'Date'			=> $item->get_date($this->dateFormat),
						'Description' 	=> $item->get_description(),
						'Author'		=> $item->get_author(),
						'Link'			=> $item->get_link(),
						'Content'		=> $item->get_content(),
				)));
			}
		}
		
		return $feedList;
	}
	
	
}