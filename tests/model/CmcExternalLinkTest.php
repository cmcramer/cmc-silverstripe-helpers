<?php
class CmcExternalLinkTest extends SapphireTest {

    /** @var Array of CmcExternalLink */
    private $externalLink;
    
    /** @var string  */
    protected static $fixture_file = 'CmcExternalLinkTest.yml';
    
    public function setUp() {
        parent::setUp();
        $this->externalLink = array();
        for ($i=1;$i<4;$i++) {
            $this->externalLink[] = $this->objFromFixture('CmcExternalLink', "link{$i}");
        }
    }
    
    public function testTitle() {
        $this->assertEquals('NOAA', $this->externalLink[0]->getTitle());
        $this->assertEquals('Accuweather', $this->externalLink[1]->getTitle());
        $this->assertEquals('Yahoo Weather', $this->externalLink[2]->getTitle());
    }
    public function testDescriptionNull() {
        for ($i=1;$i<3;$i++) {
            $this->assertEquals('', $this->externalLink[$i]->Description);
        }
    }
    
}