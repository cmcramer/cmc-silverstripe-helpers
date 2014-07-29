<?php
/**
 * 
 * @author cmc
 *
 * SilverStripe's summary and text chopping functions delete all HTML.
 * These functions retain HTML
 */
class CmcHtmlTextHelper {
	
	/**
	 * Make HTML save my matching closing tags.
	 */
	//based on stage_modules/utility/fns.news_events.php chopString()
	public static function HtmlSummary ($strHtml, $maxChars, $stripTags=false, $strClose=" ...") {
		
		if ($stripTags) $strHtml = strip_tags($strHtml);
		//Debug::show($strHtml);
		
		if (strlen($strHtml) > $maxChars) {
			$strHtml = substr($strHtml, 0, $maxChars-1);
			$lastSpace = strrpos($strHtml, " ");
			$strHtml = substr($strHtml, 0, $lastSpace);
			if (substr($strHtml, $lastSpace-1, 1) == ',') {
				$strHtml = substr($strHtml, 0, $lastSpace-1);
			}
			$strHtml = $strHtml . $strClose;
		}
		return $strHtml;
	}
	
	
}