<?php

namespace ModelModuleTest\Model\Users\Settori;

use ModelModule\Model\Users\Settori\UsersSettoriGetter;
use ModelModuleTest\TestSuite;

class UsersSettoriGetterTest extends TestSuite
{
    /**
     * @var UsersSettoriGetter
     */
    private $objectGetter;

    protected function setUp()
    {
        parent::setUp();

        $this->objectGetter = new UsersSettoriGetter( $this->getEntityManagerMock() );
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

    public function testSetIdWithArrayInInput()
    {
        $this->objectGetter->setId( array(1,2,3) );

        $this->assertNotEmpty($this->objectGetter->getQueryBuilder()->getParameter('id'));
    }
}