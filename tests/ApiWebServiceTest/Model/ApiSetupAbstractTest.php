<?php

namespace ApiWebService\Model;

use ModelModuleTest\TestSuite;

/**
 * @author Andrea Fiori
 * @since  23 August 2014
 */
class ApiSetupAbstractTest extends TestSuite
{
    /**
     * @var \ApiWebService\Model\ApiSetupAbstract
     */
    private $apiSetupAbstract;

    private $validInputSample;
    
    protected function setUp()
    {
        parent::setUp();
        
        $this->apiSetupAbstract = $this->getMockForAbstractClass('\ApiWebService\Model\ApiSetupAbstract');
        
        $this->validInputSample = array(
            'key'       => 'myApiKey',
            'username'  => 'myUsername',
            'password'  => 'myPassword'
        );
    }
    
    public function testSetMethod()
    {
        $this->apiSetupAbstract->setMethod('GET');

        $this->assertEquals($this->apiSetupAbstract->getMethod(), 'GET');
    }
    
    /**
     * @expectedException \ModelModule\Model\NullException
     */
    public function testSetUnvalidMethod()
    {
        $this->apiSetupAbstract->setMethod('UNLINK');
    }
    
    public function testSetInput()
    {
        $this->apiSetupAbstract->setInput($this->validInputSample);
        
        $this->assertTrue( is_array($this->apiSetupAbstract->getInput()) );
        $this->assertEquals($this->apiSetupAbstract->getInput('username'), 'myUsername');
    }
    
    public function testSetStatusCode()
    {
        $this->apiSetupAbstract->setStatusCode(200);
        
        $this->assertEquals($this->apiSetupAbstract->getStatusCode(), 200);
    }
    
    public function testSetEntityManager()
    {
        $this->apiSetupAbstract->setEntityManager($this->getEntityManagerMock());
        
        $this->assertInstanceOf('\Doctrine\ORM\EntityManager', $this->apiSetupAbstract->getEntityManager());
    }
}