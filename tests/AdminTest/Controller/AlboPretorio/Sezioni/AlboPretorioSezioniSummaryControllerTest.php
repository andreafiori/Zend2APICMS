<?php

namespace AdminTest\Controller\AlboPretorio\Sezioni;

use Admin\Controller\AlboPretorio\Sezioni\AlboPretorioSezioniSummaryController;
use ModelModuleTest\TestSuite;

class AlboPretorioSezioniSummaryControllerTest extends TestSuite
{
    /**
     * @var AlboPretorioSezioniSummaryController
     */
    protected $controller;

    protected function setUp()
    {
        parent::setUp();

        $this->controller = new AlboPretorioSezioniSummaryController();
        $this->controller->setEvent($this->event);
        $this->controller->setServiceLocator($this->getServiceManager());
    }

    public function testIndexAction()
    {
        $this->routeMatch->setParam('action', 'index');

        $this->controller->dispatch($this->request);

        $this->assertEquals(200, $this->controller->getResponse()->getStatusCode());
    }
}
