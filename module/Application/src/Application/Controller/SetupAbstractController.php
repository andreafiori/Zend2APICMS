<?php

namespace Application\Controller;

use Admin\Model\Sezioni\SezioniGetter;
use Admin\Model\Sezioni\SezioniGetterWrapper;
use Application\Model\SetupAbstractControllerHelper;
use Application\Setup\UserInterfaceConfigurations;
use Admin\Model\Log\LogWriter;
use Admin\Service\AppServiceLoader;
use Admin\Model\Config\ConfigGetter;
use Admin\Model\Config\ConfigGetterWrapper;
use Zend\Mvc\MvcEvent;
use Zend\Session\Container as SessionContainer;
use Zend\View\Model\ViewModel;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;

abstract class SetupAbstractController extends AbstractActionController
{
    const formTemplate = 'formdata/formdata.phtml';

    const summaryTemplate = 'datatable/datatable.phtml';

    /**
     * @var ViewModel
     */
    protected $viewModel;

    /**
     * @param int $channel
     * @return string
     */
    protected function initializeAdminArea($channel = 1)
    {
        $appServiceLoader = $this->recoverAppServiceLoader($channel);

        $configurations = $appServiceLoader->recoverService('configurations');

        $sessionContainer = new SessionContainer();

        if (!$this->checkPasswordPreviewArea($configurations, $sessionContainer)) {
            header("Location: ".$this->url()->fromRoute('password-preview'));
            exit;
        }

        $request = $this->getRequest();

        $helper = new SetupAbstractControllerHelper();
        $helper->setConfigurations($configurations);
        $helper->setRequest($request);
        $helper->setupZf2appDir();
        $helper->setupAppDirRelativePath();

        $templateBackend    = $helper->getConfigurations('template_backend', 1);
        $uri                = $request->getUri();
        $basePath           = sprintf('%s://%s%s', $uri->getScheme(), $uri->getHost(), $request->getBaseUrl().'/');
        $cookieWarning      = $sessionContainer->offsetGet($configurations['sitename']);

        $this->layout()->setVariables(array_merge(
            $configurations,
            array(
                'publicDirRelativePath' => $helper->getAppDirRelativePath().'/public',
                'baseUrl'               => sprintf($basePath.'admin/main/'.$this->params()->fromRoute('lang').'/'),
                'basePath'              => $basePath,
                'userDetails'           => $sessionContainer->offsetGet('userDetails'),
                'preloadResponse'       => $helper->getConfigurations('preloadResponse', 1),
                'templateDir'           => 'backend/templates/'.$templateBackend,
                'formDataCommonPath'    => 'backend/templates/common/',
                'passwordPreviewArea'   => $this->hasPasswordPreviewArea($configurations),
                'cookieWarning'         => !empty($cookieWarning) ? $cookieWarning : null,
            )
        ));

        return 'backend/templates/'.$templateBackend.'backend.phtml';
    }

    /**
     * Initialize variables for the public website
     *
     * @return string
     */
    protected function initializeFrontendWebsite($channel = 1)
    {
        $appServiceLoader = $this->recoverAppServiceLoader($channel);

        $configurations = $appServiceLoader->recoverService('configurations');

        $sessionContainer = new SessionContainer();

        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

        $lang = $this->params()->fromRoute('lang');

        if (!$this->checkPasswordPreviewArea($configurations, $sessionContainer)) {
            header("Location: ".$this->url()->fromRoute('password-preview'));
            exit;
        }

        $request = $this->getRequest();

        $wrapper = new SezioniGetterWrapper(new SezioniGetter($em));
        $wrapper->setInput(array(
            'orderBy'               => 'sezioni.posizione ASC',
            'attivo'                => 1,
            'languageAbbreviation'  => isset($lang) ? $lang : 'it',
        ));
        $wrapper->setupQueryBuilder();

        $sezioniRecords = $wrapper->formatRecordsPerColumn(
            $wrapper->addSottoSezioni($wrapper->getRecords(), array('attivo'=>1))
        );

        $helper = new SetupAbstractControllerHelper();
        $helper->setConfigurations($configurations);
        $helper->setRequest($request);
        $helper->setSezioniRecords($sezioniRecords);
        $helper->setupServer();
        $helper->setupFrontendTemplatePath();
        $helper->setupPhpRenderer( $this->getServiceLocator() );
        $helper->setupZf2appDir();
        $helper->setupAppDirRelativePath();

        $serverVars             = $helper->getServer();
        $cookieWarningSession   = $sessionContainer->offsetGet('cookie-warning');
        $uri                    = $request->getUri();

        $serviceLocator = $this->getServiceLocator();

        /**
         * @var \Zend\Mvc\I18n\Translator $translator
         */
        $translator = $serviceLocator->get('translator');
        if ( file_exists('./module/Application/language/app.'.$lang.'.php') ) {
            $translator->addTranslationFile('phparray', './module/Application/language/app.'.$lang.'.php');
        }
        if ( file_exists('./module/Application/language/form.array.'.$lang.'.php') ) {
            $translator->addTranslationFile('phparray', './module/Application/language/form.array.'.$lang.'.php');
        }
        $serviceLocator->get('ViewHelperManager')->get('translate')->setTranslator($translator);

        $this->layout()->setVariables($configurations);
        $this->layout()->setVariables( array(
            'basePath'              => sprintf('%s://%s%s', $uri->getScheme(), $uri->getHost(), $request->getBaseUrl().'/'),
            'publicDirRelativePath' => $helper->getAppDirRelativePath().'/public',
            'configurations'        => $configurations,
            'sezioni'               => $helper->getSezioniRecords(),
            'templateDir'           => 'frontend/projects/'.$configurations['project_frontend'].'templates/'.$configurations['template_frontend'],
            'preloadResponse'       => isset($input['preloadResponse']) ? $input['preloadResponse'] : null,
            'currentUrl'            => "http://".$serverVars["SERVER_NAME"].$serverVars["REQUEST_URI"],
            'currentDateTime'       => date("Y-m-d H:i:s"),
            'template_frontend'     => $configurations['template_frontend'],
            'cssName'               => $sessionContainer->offSetGet('cssName'),
            'passwordPreviewArea'   => $this->hasPasswordPreviewArea($configurations),
            'renderer'              => $helper->getPhpRenderer(),
            'cookieWarning'         => isset($cookieWarningSession[$configurations['sitename']]) ? $cookieWarningSession[$configurations['sitename']] : null,
            'lang'                  => (isset($lang)) ? $lang : 'it',
        ));

        return 'frontend/projects/'.$configurations['project_frontend'].'templates/'.$configurations['template_frontend'] .'layout.phtml';
    }

    /**
     * @return \Admin\Service\AppServiceLoader
     */
    protected function recoverAppServiceLoader($channel = 1)
    {
        $sl = $this->getServiceLocator();
        $em = $sl->get('Doctrine\ORM\EntityManager');
        $sm = $sl->get('servicemanager');

        $appServiceLoader = new AppServiceLoader();

        $appServiceLoader->setProperties(array(
                'serviceLocator'    => $sl,
                'serviceManager'    => $sm,
                'entityManager'     => $em,
                'queryBuilder'      => $em->createQueryBuilder(),
                'translator'        => $sm->get('translator'),
                'moduleConfigs'     => $sm->get('config'),
                'request'           => $sm->get('request'),
                'router'            => $sm->get('request'),
            )
        );

        $appServiceLoader->recoverRouter();
        $appServiceLoader->recoverRouteMatch();
        $appServiceLoader->setService('channel', $channel);
        $appServiceLoader->setController($this);
        $appServiceLoader->setupParams();
        $appServiceLoader->setupRedirect();
        $appServiceLoader->setupConfigurations( new ConfigGetterWrapper(new ConfigGetter($em)) );
        $appServiceLoader->setupUserInterfaceConfigurations(
            new UserInterfaceConfigurations($appServiceLoader->recoverService('configurations'))
        );
        return $appServiceLoader;
    }

    /**
     * Check parameters for the password preview area
     *
     * @param array $configurations
     * @param SessionContainer $sessionContainer
     *
     * @return bool
     */
    public function checkPasswordPreviewArea(array $configurations, SessionContainer $sessionContainer)
    {
        if (!$this->hasPasswordPreviewArea($configurations)) {
            return true;
        }

        if ( isset($configurations['preview_password_area']) and $sessionContainer->offsetGet('preview_area_ok')!=1) {
            return false;
        }

        $dateDiff = date_diff(
            date_create($sessionContainer->offsetGet('preview_area_logintimeout')),
            date_create(date("Y-m-d H:i:s"))
        );

        if ($dateDiff->i > 60) {
            $sessionContainer->offsetUnset('preview_area_ok');
            $sessionContainer->offsetUnset('preview_area_logintimeout');
            return false;
        }

        return true;
    }

    /**
     * Check if the password preview area is activated
     *
     * @param array $configurations
     * @return bool
     */
    public function hasPasswordPreviewArea(array $configurations)
    {
        if ( isset($configurations['preview_password_area']) and $configurations['preview_password_area']==1) {
            return true;
        }

        return false;
    }

    /**
     * @return \stdClass
     */
    protected function recoverUserDetails()
    {
        $session = new SessionContainer();

        return $session->offsetGet('userDetails');
    }

    /**
     * @return mixed
     */
    protected function recoverAcl()
    {
        $session = new SessionContainer();

        return $session->offsetGet('userDetails')->acl;
    }

    /**
     * @param array $logArray
     * @return bool
     */
    protected function log(array $logArray)
    {
        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');

        $log = new LogWriter($em->getConnection());

        return $log->writeLog($logArray);
    }

    /**
     * @return \Doctrine\DBAL\Connection
     */
    protected function recoverConnection()
    {
        return $this->getServiceLocator()->get('doctrine.entitymanager.orm_default')->getConnection();
    }

    /**
     * @return Response
     */
    protected function redirectForUnvalidAccess()
    {
        if (is_object( $this->getRequest()->getHeader('Referer'))) {
            return $this->redirect()->toUrl(
                $this->getRequest()->getHeader('Referer')->uri()->getPath()
            );
        }

        return $this->redirect()->toRoute('main', array('lang' => 'it') );
    }
}
