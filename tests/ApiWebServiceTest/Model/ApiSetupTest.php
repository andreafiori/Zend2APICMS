<?php

namespace ApiWebService\Model;

use ApplicationTest\TestSuite;
use ApiWebService\Model\ApiSetup;

/**
 * @author Andrea Fiori
 * @since  22 August 2014
 */
class ApiSetupTest extends TestSuite
{
    private $apiSetup;
    
    private $validInputSample, $resouceClassMapSample;
    
    protected function setUp()
    {
        parent::setUp();
        
        $this->apiSetup = new ApiSetup();
        
        $this->validInputSample = array(
            'key'       => 'myApiKey',
            'username'  => 'myUsername',
            'password'  => 'myPassword'
        );
        
        $this->resouceClassMapSample = array(
            'contents'  => 'ApiWebService\Model\Resources\PostsApiResource',
            'blogs'     => 'ClassDoesntExist'
        );
    }

    /**
     * @expectedException \Application\Model\NullException
     */
    public function testSetInvalidResource()
    {
        $this->apiSetup->setResourceClassName('invalid-resource');
    }
    
    /**
     * @expectedException \Application\Model\NullException
     */
    public function testSetInvalidResourceWithNonExistentClass()
    {
        $this->apiSetup->setResourceClassMap( $this->resouceClassMapSample );
        
        $this->apiSetup->setResourceClassName('blogs');
    }
}
