<?php

namespace Admin\Model\Users\Roles;

use Application\Model\RecordsGetterWrapperAbstract;

/**
 * @author Andrea Fiori
 * @since  28 February 2015
 */
class UsersRolesGetterWrapper extends RecordsGetterWrapperAbstract
{
    /**
     * @var UsersRoles
     */
    protected $objectGetter;

    /**
     * @param UsersRoles $usersGetter
     */
    public function __construct(UsersRolesGetter $objectGetter)
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