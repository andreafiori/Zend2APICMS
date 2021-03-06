<?php

namespace ModelModuleTest\Model\StatoCivile\Sezioni;

use ModelModuleTest\TestSuite;
use ModelModule\Model\StatoCivile\Sezioni\StatoCivileSezioniGetter;

class StatoCivileSezioniGetterTest extends TestSuite
{
    /**
     * @var StatoCivileSezioniGetter
     */
    private $objectGetter;
    
    protected function setUp()
    {
        parent::setUp();
        
        $this->objectGetter = new StatoCivileSezioniGetter( $this->getEntityManagerMock() );
    }
    
    public function testSetMainQuery()
    {
        $this->objectGetter->setMainQuery();
        
        $this->assertTrue( is_array($this->objectGetter->getQueryResult()) );
    }
    
    public function testSetId()
    {
        $this->objectGetter->setId(1);
        
        $this->assertNotEmpty($this->objectGetter->getQueryBuilder()->getParameter('id'));
    }
    
    public function testSetIdWithArrayParameter()
    {
        $this->objectGetter->setId(array(1,2,3));
        
        $this->assertNotEmpty($this->objectGetter->getQueryBuilder()->getParameter('id'));
    }
}