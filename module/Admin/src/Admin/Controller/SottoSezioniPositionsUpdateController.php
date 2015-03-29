<?php

namespace Admin\Controller;

use Application\Controller\SetupAbstractController;
use Application\Model\Database\DbTableContainer;

/**
 * @author Andrea Fiori
 * @since  27 March 2015
 */
class SottoSezioniPositionsUpdateController extends SetupAbstractController
{
    public function indexAction()
    {
        if (!$this->checkLogin()) {
            return $this->redirect()->toRoute('login');
        }

        $appServiceLoader = $this->recoverAppServiceLoader();

        $items = $this->params()->fromQuery('oggettoItem');

        $connection = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default')->getConnection();

        if (!empty($items)):
            foreach ($items as $position => $item):
                $connection->update(
                    DbTableContainer::sottosezioni,
                    array('posizione' => $position),
                    array('id'        => $item)
                );
            endforeach;
        endif;

        $this->layout('backend/templates/'.$appServiceLoader->recoverServiceKey('configurations', 'template_backend').'sezioni/sottosezioni/positions_message.phtml');
    }
}