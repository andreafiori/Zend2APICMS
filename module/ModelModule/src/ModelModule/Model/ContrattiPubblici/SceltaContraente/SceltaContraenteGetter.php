<?php

namespace ModelModule\Model\ContrattiPubblici\SceltaContraente;

use ModelModule\Model\QueryBuilderHelperAbstract;

class SceltaContraenteGetter extends QueryBuilderHelperAbstract
{
    public function setMainQuery()
    {
        $this->setSelectQueryFields('csc.id, csc.nomeScelta, csc.attivo ');

        $this->getQueryBuilder()->select( $this->getSelectQueryFields() )
                                ->from('Application\Entity\ZfcmsComuniContrattiScContr ', 'csc')
                                ->where('csc.id != 0 ');
        
        return $this->getQueryBuilder();
    }

    /**
     * @param number|array $id
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function setId($id)
    {
        if ( is_numeric($id) ) {
            $this->getQueryBuilder()->andWhere('csc.id = :id ');
            $this->getQueryBuilder()->setParameter('id', $id);
        }
        
        if (is_array($id)) {
            $this->getQueryBuilder()->andWhere('csc.id IN ( :id ) ');
            $this->getQueryBuilder()->setParameter('id', $id);
        }
        
        return $this->getQueryBuilder();
    }

    /**
     * @param string $nomeScelta
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function setNomeScelta($nomeScelta)
    {
        if ($nomeScelta) {
            $this->getQueryBuilder()->andWhere('csc.$nomeScelta = :nomeScelta ');
            $this->getQueryBuilder()->setParameter('nomeScelta', $nomeScelta);
        }
        
        return $this->getQueryBuilder();
    }
}