<?php
//include_once(Director::getAbsFile(SAPPHIRE_DIR . '/thirdparty/simplepie/simplepie.inc'));
class CmcRssReader {
	
	protected $url;  
	protected $dateFormat;
	protected $feed;
	
	
	public function __construct($strFeedUrl, $limit=10, $dateFormat="j.M.y") {
		$strFeedUrl = preg_replace('#^http(s)?://#', '', $strFeedUrl); //remove http:// or https:// 
		if ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ) {
			$protocol = 'https://';
		} else {
			$protocol = 'http://';
		}
		$this->url = $protocol.$strFeedUrl;
		$this->dateFormat = $dateFormat;
	}
	
	public function FeedItems() {
		$this->feed->init();
		$feedList = new ArrayList();
		
		if ($this->feed->get_items()) {
			$this->feed = new SimplePie($this->url, 0, $limit);
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