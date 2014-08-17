<?php

namespace Admin\Model\AlboPretorio;

use Application\Model\RecordsGetterWrapperAbstract;

/**
 * @author Andrea Fiori
 * @since  08 July 2014
 */
class AlboPretorioGetterWrapper extends RecordsGetterWrapperAbstract
{
    /** @var \Admin\Model\AlboPretorio\AlboPretorioGetter **/
    protected $objectGetter;

    /**
     * @param \Admin\Model\AlboPretorio\AlboPretorioGetter $alboPretorioGetter
     */
    public function __construct(AlboPretorioGetter $alboPretorioGetter)
    {
        $this->setObjectGetter( $alboPretorioGetter );
    }
    
    /**
     * setup and execute query
     */
    public function setupQueryBuilder()
    {       
        $this->objectGetter->setSelectQueryFields( $this->getInput('fields', 1) );
        
        $this->objectGetter->setMainQuery();        
        $this->objectGetter->setId($this->getInput('id', 1));
        $this->objectGetter->setNumeroProgressivo($this->getInput('numeroProgressivo', 1));
        $this->objectGetter->setNumeroAtto($this->getInput('numeroAtto', 1));
        $this->objectGetter->setAnno($this->getInput('anno', 1));
        $this->objectGetter->setDataScadenza($this->getInput('dataScadenza', 1));
        $this->objectGetter->setOrderBy($this->getInput('orderBy', 1));
        $this->objectGetter->setLimit($this->getInput('limit', 1));
    }
}
