<?php
class CmcYouTubeEmbedFunctionalTest extends FunctionalTest {
    /** WARNING DON'T USE FUNCTIONAL TEST. 
        DOESN'T WORK EXCEPT FOR PAGES CREATED WITHIN TEST */
    
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
// 		RootURLController::reset();
//         //$response = $this->get($this->youTubeEmbed->WatchOnYouTubeUrl());
//         $response = $this->get('/');
//         //$response = Director::test('/dev/');
//         //Debug::show(Injector::inst()->get('RequestProcessor'));
//         //Debug::show($this->mainSession->lastUrl());
//         //Debug::show($response);
//         $this->assertEquals(200, $response->getStatusCode());
    }
}