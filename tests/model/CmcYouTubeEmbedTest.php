<?php
class CmcYouTubeEmbedTest extends SapphireTest {
    
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
    
    public function testTitle() {
        $this->assertEquals('COC Webcam', $this->youTubeEmbed->getTitle());
    }
    
    public function testVideoId() {
        $this->assertEquals('nkPaO3iK4QQ', $this->youTubeEmbed->YouTubeId);
    }
    
    public function testDefaults() {
        //Debug::show($this->youTubeEmbed);
        $this->assertEquals(360, $this->youTubeEmbed->Height);
        $this->assertEquals(640, $this->youTubeEmbed->Width);
        $this->assertEquals(1, $this->youTubeEmbed->AutoPlay);
        $this->assertEquals(0, $this->youTubeEmbed->ShowInfo);
    }
    

}
