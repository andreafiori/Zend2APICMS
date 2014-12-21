<?php

namespace Admin\Model\Logs;

/**
 * @author Andrea Fiori
 * @since  12 December 2014
 */
class LogsGetterWrapper
{
    /**
     * @var LogsGetter 
     */
    protected $objectGetter;

    /**
     * @param LogsGetter $objectGetter
     */
    public function __construct(LogsGetter $objectGetter)
    {
        $this->setObjectGetter($objectGetter);
    }
    
    public function setupQueryBuilder()
    {
        $this->objectGetter->setSelectQueryFields( $this->getInput('fields', 1) );
        
        $this->objectGetter->setMainQuery();
        
        $this->objectGetter->setId( $this->getInput('id', 1) );
        $this->objectGetter->setOrderBy( $this->getInput('orderBy', 1) );
        $this->objectGetter->setGroupBy( $this->getInput('groupBy', 1) );
        $this->objectGetter->setLimit( $this->getInput('limit', 1) );
    }
}