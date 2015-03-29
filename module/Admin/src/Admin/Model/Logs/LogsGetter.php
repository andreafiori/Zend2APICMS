<?php

namespace Admin\Model\Logs;

use Application\Model\QueryBuilderHelperAbstract;

/**
 * @author Andrea Fiori
 * @since  12 December 2014
 */
class LogsGetter extends QueryBuilderHelperAbstract
{
    public function setMainQuery()
    {
        $this->setSelectQueryFields('
                                    l.id, l.datetime, l.message, l.type, l.backend,

                                    u.id, u.name, u.surname
                                    ');

        $this->getQueryBuilder()->select( $this->getSelectQueryFields() )
                                ->from('Application\Entity\ZfcmsLogs', 'l')
                                ->join('l.user', 'u')
                                ->where('l.id != 0 ');
        
        return $this->getQueryBuilder();
    }

    /**
     * @param int|array $id
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function setId($id)
    {
        if ( is_numeric($id) ) {
            $this->getQueryBuilder()->andWhere('l.id = :id ');
            $this->getQueryBuilder()->setParameter('id', $id);
        }
        
        if (is_array($id)) {
            $this->getQueryBuilder()->andWhere('l.id IN ( :id ) ');
            $this->getQueryBuilder()->setParameter('id', $id);
        }
        
        return $this->getQueryBuilder();
    }

    public function setUserId($id)
    {
        if ( is_numeric($id) ) {
            $this->getQueryBuilder()->andWhere('u.id = :id ');
            $this->getQueryBuilder()->setParameter('id', $id);
        }

        return $this->getQueryBuilder();
    }
}
