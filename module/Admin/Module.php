<?php

namespace Admin;

use ServiceLocatorFactory\ServiceLocatorFactory;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Validator\AbstractValidator;
use ModelModule\Model\Config\ConfigGetter;
use ModelModule\Model\Config\ConfigGetterWrapper;
use Zend\Session\Container as SessionContainer;

class Module implements AutoloaderProviderInterface, ConfigProviderInterface
{
    /**
     * @param MvcEvent $e
     */
    public function onBootstrap(MvcEvent $e)
    {
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($e->getApplication()->getEventManager());

        $eventManager = $e->getApplication()->getEventManager();
        $eventManager->attach(MvcEvent::EVENT_DISPATCH, array($this, 'preDispatch'), 2);
    }

    /**
     * @param MvcEvent $e
     * @throws \Exception
     * @throws \ServiceLocatorFactory\NullServiceLocatorException
     */
    public function preDispatch(MvcEvent $e)
    {
        $application   = $e->getApplication();
        $sm            = $application->getServiceManager();

        $router = $sm->get('router');
        $request = $sm->get('request');
        $matchedRoute = $router->match($request);

        $params = $matchedRoute->getParams();
        $controller = $params['controller'];

        if (!isset($controller)) {
            return false;
        }

        $currentControllerNamespace = explode('\\', $controller);

        if ($currentControllerNamespace[0] == 'Admin') {
            $sl = ServiceLocatorFactory::getInstance();

            $session = new SessionContainer();

            $userDetails = $session->offsetGet('userDetails');

            /* Check Admin Area login */
            if ( !$sl->get('AuthService')->hasIdentity() or $userDetails->sitename != $this->recoverSitename($sl) ) {

                $url = $e->getRouter()->assemble(array('action' => 'index'), array('name' => 'login'));

                $response = $e->getResponse();
                $response->getHeaders()->addHeaderLine('Location', $url);
                $response->setStatusCode(302);
                $response->sendHeaders();
                exit;
            }

            // Check ACL
            $roles = include __DIR__ . '/config/module.acl.roles.php';

            foreach($roles as $key => $value) {
                if ($key == $matchedRoute->getMatchedRouteName()) {

                    if (isset($value['resources'])) {
                        $allowed = 0;
                        foreach($value['resources'] as $resource) {
                            if ($userDetails->acl->hasResource($resource)) {
                                $allowed = 1;
                            }
                        }

                        /* No permissions, redirect... */
                        if ($allowed==0) {
                            $url = $e->getRouter()->assemble(
                                array('lang' => 'it'),
                                array('name' => 'admin/not-authorized')
                            );

                            $response = $e->getResponse();
                            $response->getHeaders()->addHeaderLine('Location', $url);
                            $response->setStatusCode(401);
                            $response->sendHeaders();
                            exit;
                        }
                    }

                }
            }

        }
    }

        /**
         * @return mixed
         * @throws \Exception
         */
        private function recoverSitename($sl)
        {
            $configGetterWrapper = new ConfigGetterWrapper(new ConfigGetter(
                    $sl->get('doctrine.entitymanager.orm_default')
                )
            );
            $configGetterWrapper->setInput(array(
                'name'      => 'sitename',
                'channel'   => 1,
                'language'  => 1,
                'limit'     => 1
            ));
            $configGetterWrapper->setupQueryBuilder();

            $records = $configGetterWrapper->getRecords();

            if (empty($records)) {
                throw new \Exception("Errore: nome sito non rilevato fra le configurazioni");
            }

            return $records[0]['value'];
        }

    /**
     * {@inheritDoc}
     */
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

    /**
     * @return array
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * @return array
     */
    public function getServiceConfig()
    {
        return array( 'factories' => array() );
    }    
}
