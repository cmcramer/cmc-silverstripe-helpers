<?php
class CmcYouTubeEmbed extends DataObject {
    
    private static $singular_name = 'Embedded YouTube Video';
    private static $plural_name = 'Embedded YouTube Videos';
    
    
    private static $db = array(
        'YouTubeTitle'     => 'Varchar(255)',
        'YouTubeId' => 'Varchar(100)',
        'Width'     => 'Int',
        'Height'    => 'Int',
        'AutoPlay'  => 'CmcBoolean',
        'ShowInfo'  => 'CmcBoolean',
    );
    
    private static $has_one = array(
        'PageWithVideo' => 'Page',
    );
        
    
    private static $summary_fields = array(
        'YouTubeTitle'                     => 'YouTube Video',
    );
    
    private static $default_sort = array(
        'YouTubeTitle',
    );
    
    
    private static $display_fields = array(
        'Title'             => 'YouTube Video',
        'YouTubeId'         => 'Video ID',
        'AutoPlay.NiceCMS'  => 'Auto Play',
        'ShowInfo.NiceCMS'  => 'Show Info',
    );
    


    private static $defaults = array(
        'Width'	    => 640,
        'Height'    => 360,
        'AutoPlay'  => true,
        'ShowInfo'  => false,
    );
    
    public function getTitle() {
        return $this->YouTubeTitle;
    }
    
    public function WatchOnYouTubeUrl() {
        $strUrl = "https://www.youtube.com/watch?v={$this->YouTubeId}";
        return $strUrl;
    }
    
    public function VideoIframe() {
       
        if ($this->AutoPlay) {
            $strAutoPlay = '&autoplay=1';
        } else {
            $strAutoPlay = '&autoplay=0';
        }
        if ($this->ShowInfo) {
            $strShowInfo = '&showinfo=1';
        } else {
            $strShowInfo = '&showinfo=0';
        }
        $strHtml = <<<EOT
        <iframe width="{$this->Width}" height="{$this->Height}" 
            src="https://www.youtube.com/embed/{$this->YouTubeId}?rel=0{$strAutoPlay}{$strShowInfo}" 
                frameborder="0"></iframe>
EOT;
        
        return $strHtml;
    }


}