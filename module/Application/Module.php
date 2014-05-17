<?php

namespace Application;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module implements AutoloaderProviderInterface
{
    public function onBootstrap(MvcEvent $e)
    {
    	$application = $e->getApplication();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach( $application->getEventManager() );
        $sm = $application->getServiceManager();
        try {
            $dbInstance = $sm->get('Zend\Db\Adapter\Adapter');
            $dbInstance->getDriver()->getConnection()->connect();
        } catch (\Exception $ex) {
            $ViewModel = $e->getViewModel();
            $ViewModel->setTemplate('layout/layout');
                 
            $content = new \Zend\View\Model\ViewModel();
            $content->setTemplate('error/dbconnection');

            $ViewModel->setVariable('content', $sm->get('ViewRenderer')
                                                  ->render($content));
             
            exit( $sm->get('ViewRenderer')->render($ViewModel) );
        }
        
        $em = $application->getEventManager();
        $em->attach(\Zend\Mvc\MvcEvent::EVENT_DISPATCH_ERROR, array($this, 'handleError'));
        $em->attach(\Zend\Mvc\MvcEvent::EVENT_RENDER_ERROR, array($this, 'handleError'));
    }
    
    /**
     * TODO: handle errors exceptions and controller not found
     * 
     * @param MvcEvent $e
     */
    public function handleError(MvcEvent $e)
    {
    	$exception = $e->getParam('exception');
    }
    
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
    /**
     * Configure plain text and custom form elements
     * @return multitype:multitype:string
     */
    public function getViewHelperConfig()
    {
        return array(
            'invokables' 	=> array(
                'formelement'   => 'Application\Form\View\Helper\FormElement',
                'formPlainText' => 'Application\Form\View\Helper\FormPlainText',
                )
        );
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/' , __NAMESPACE__),
                ),
            ),
        );
    }
    
    public function getServiceConfig()
    {
    	return array( 'factories' => array() );
    }
}