<?php

namespace ServiceLocatorFactoryTest;

use ApplicationTest\TestSuite;
use ServiceLocatorFactory\ServiceLocatorFactory;
use Zend\ServiceManager\ServiceManager;

/**
 * @author Andrea Fiori
 * @since  07 January 2014
 */
class ServiceLocatorFactoryTest extends TestSuite
{
    /**
     * @expectedException \ServiceLocatorFactory\NullServiceLocatorException
     */
    public function testGetinstance()
    {
        ServiceLocatorFactory::getInstance();
    }

    public function testSetinstance()
    {
        ServiceLocatorFactory::setInstance( $this->getServiceManager() );

        $this->assertTrue( ServiceLocatorFactory::getInstance() instanceof ServiceManager );
    }
}