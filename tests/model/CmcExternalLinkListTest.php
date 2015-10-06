<?php
class CmcExternalLinkListTest extends SapphireTest {

    /** @var Array of CmcExternalLink */
    private $externalLinkList;
    
    /** @var string  */
    protected static $fixture_file = 'CmcExternalLinkListTest.yml';
    
    public function setUp() {
        parent::setUp();
        $this->externalLinkList = $this->objFromFixture('CmcExternalLinkList', 'TestList');
        for ($i=1;$i<4;$i++) {
            $this->externalLinkList->ExternalLinks()->add($this->objFromFixture('CmcExternalLink', "link{$i}"));
        }
    }
    
    public function testTitle() {
        $this->assertEquals('External Links', $this->externalLinkList->getTitle());
    }
    
    public function testList() {
        foreach($this->externalLinkList->ExternalLinks() as $link) {
            switch ($link->ID) {
                case 1 :
                    $val = 'NOAA';
                    break;
                case 2: 
                    $val = 'Accuweather';
                    break;
                case 3:
                    $val = 'Yahoo Weather';
                    break;
                default:
                    $val = '';
            }
            $this->assertEquals($val, $link->getTitle());
        }
    }
    
}