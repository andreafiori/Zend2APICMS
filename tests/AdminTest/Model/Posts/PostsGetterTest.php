<?php

namespace AdminTest\Model\Posts;

use ApplicationTest\TestSuite;
use Admin\Model\Posts\PostsGetter;

/**
 * @author Andrea Fiori
 * @since  05 May 2014
 */
class PostsGetterTest extends TestSuite
{
    /**
     * @var PostsGetter
     */
    private $objectGetter;
    
    protected function setUp()
    {
        parent::setUp();
        
        $this->objectGetter = new PostsGetter( $this->getEntityManagerMock() );
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

    public function testSetCategorySlug()
    {
        $this->objectGetter->setCategorySlug('my-category-slug');
        
        $this->assertNotEmpty($this->objectGetter->getQueryBuilder()->getParameter('categorySlug'));
    }

    public function testSetTitle()
    {
        $this->objectGetter->setTitle('MyPostTitle');
        
         $this->assertNotEmpty($this->objectGetter->getQueryBuilder()->getParameter('title'));
    }
    
    public function testSetType()
    {
        $this->objectGetter->setType('content');

        $this->assertNotEmpty($this->objectGetter->getQueryBuilder()->getParameter('postType'));
    }
    
    public function testSetStatus()
    {
        $this->objectGetter->setStatus();
        $this->assertEmpty($this->objectGetter->getQueryBuilder()->getParameter('status'));
        
        $this->objectGetter->setStatus('active');
        $this->assertNotEmpty($this->objectGetter->getQueryBuilder()->getParameter('status'));
    }

    public function testModuleCode()
    {
        $this->objectGetter->setModuleCode('blogs');

        $this->assertNotEmpty($this->objectGetter->getQueryBuilder()->getParameter('moduleCode'));
    }
}
