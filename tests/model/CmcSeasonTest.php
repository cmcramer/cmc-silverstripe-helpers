<?php
class CmcSeasonTest extends SapphireTest {

    /** @var Array of CmcSeason */
    private $Season;
    
    /** @var string  */
    protected static $fixture_file = 'CmcSeasonTest.yml';
    
    public function setUp() {
        parent::setUp();
        $this->Season = array();
        for ($i=1;$i<4;$i++) {
            $this->Season[] = $this->objFromFixture('CmcSeason', "season{$i}");
        }
    }
    
    public function testTitle() {
        $this->assertEquals('2015-16 Nordic Season', $this->Season[0]->getTitle());
        $this->assertEquals('2014-15 Nordic Season', $this->Season[1]->getTitle());
        $this->assertEquals('2014-15 Nordic Season Alt', $this->Season[2]->getTitle());
    }
    public function testStartDate() {
        $this->assertEquals('2015-11-02', $this->Season[0]->StartDate());
        $this->assertEquals('2014-11-01', $this->Season[1]->StartDate());
        $this->assertEquals('2015-11-01', $this->Season[2]->StartDate());
    }
    public function testEndDate() {
        //'' set to today
        $this->assertEquals(date("Y-m-d"), $this->Season[0]->EndDate());
        $this->assertEquals('2015-05-10', $this->Season[1]->EndDate());
        //earlier enddate set to today
        $this->assertEquals(date("Y-m-d"), $this->Season[2]->EndDate());
    }
    
}