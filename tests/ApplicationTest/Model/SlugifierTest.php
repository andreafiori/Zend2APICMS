<?php

namespace ApplicationTest\Model;

use ApplicationTest\TestSuite;
use Application\Model\Slugifier;

/**
 * @author Andrea Fiori
 * @since  27 July 2014
 */
class SlugifierTest extends TestSuite
{
    protected function setUp()
    {
        parent::setUp();
    }
    
    public function testSlugify()
    {    
        $this->assertEquals(Slugifier::slugify("Today's post"), 'today-s-post');
    }
    
    public function testDeSlugify()
    {
        
    }
}
