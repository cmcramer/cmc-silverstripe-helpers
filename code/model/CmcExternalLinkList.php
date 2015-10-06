<?php
class CmcExternalLinkList extends DataObject {

    private static $singular_name = 'Link List';
    private static $plural_name = 'Link Lists';
    
    private static $db = array(
        'Title' => 'Varchar(255)',
    );
    
    private static $has_many = array(
        'ExternalLinks' => 'CmcExternalLink',
    );
    
    
    public function LinkListHtml($showDescription=true) {
        $strHtml = <<<EOT
            <div class="cmc-link-list"><span class="link-list-title">{$this->Title}</span>
EOT;
        
        foreach ($this->ExternalLinks as $link) {
            if ($showDescription) {
                $strHtml .= $link->LinkWithDescriptionHtml();
            } else {
                $strHtml .= $link->LinkHtml();
            }
        }
        
        $strHtml .= '</div><!-- .cmc-link-list -->';
        
        return $strHtml;
    }
    
}