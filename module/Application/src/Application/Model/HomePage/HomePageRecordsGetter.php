<?php

namespace Application\Model\HomePage;

use Application\Model\QueryBuilderHelperAbstract;

/**
 * @author Andrea Fiori
 * @since  22 June 2014
 */
class HomePageRecordsGetter extends QueryBuilderHelperAbstract
{
    public function setMainQuery()
    {
        $this->setSelectQueryFields('h.referenceId, h.position, h.freeText, IDENTITY(hb.module) AS moduleId ');

        $this->getQueryBuilder()->add('select', $this->getSelectQueryFields())
                                ->add('from', 'Application\Entity\ZfcmsHomepage h, Application\Entity\ZfcmsHomepageBlocks hb, Application\Entity\ZfcmsModules m')
                                ->add('where', " (hb.module = m.id ) AND (h.block = hb.id) ");

        return $this->getQueryBuilder();
    }
}
