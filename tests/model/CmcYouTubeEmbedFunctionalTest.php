<?php
class CmcYouTubeEmbedFunctionalTest extends FunctionalTest {
    
    /**
     * @var CmcYouTubeEmbed
     */
    private $youTubeEmbed;
    
    /**
     * @var String
     */
    protected static $fixture_file = 'CmcYouTubeEmbedTest.yml';
    
    public function setUp() {
        parent::setUp();
        $this->youTubeEmbed = $this->objFromFixture('CmcYouTubeEmbed', 'embed');
    }
    

    public function testYouTubeConnect() {
        //$response = $this->get($this->youTubeEmbed->WatchOnYouTubeUrl());
        $response = $this->get('/about-us/');
        //$response = Director::test('/dev/');
        //Debug::show(Injector::inst()->get('RequestProcessor'));
        //Debug::show($this->mainSession->lastUrl());
        //Debug::show($response);
        $this->assertEquals(200, $response->getStatusCode());
    }
}