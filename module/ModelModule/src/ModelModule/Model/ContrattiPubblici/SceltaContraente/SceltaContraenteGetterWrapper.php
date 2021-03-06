<?php

namespace ModelModule\Model\ContrattiPubblici\SceltaContraente;

use ModelModule\Model\RecordsGetterWrapperAbstract;

class SceltaContraenteGetterWrapper extends RecordsGetterWrapperAbstract
{
    /**
     * @var SceltaContraenteGetter
     */
    protected $objectGetter;
    
    /**
     * @param SceltaContraenteGetter $sceltaContraenteGetter
     */
    public function __construct(SceltaContraenteGetter $objectGetter)
    {
        $this->setObjectGetter($objectGetter);
    }

    /**
     * @return null
     */
    public function setupQueryBuilder()
    {
        $this->objectGetter->setSelectQueryFields( $this->getInput('fields', 1) );
        
        $this->objectGetter->setMainQuery();
        
        $this->objectGetter->setId( $this->getInput('id', 1) );
        $this->objectGetter->setOrderBy( $this->getInput('orderBy', 1) );
        $this->objectGetter->setLimit( $this->getInput('limit', 1) );

        return null;
    }
}