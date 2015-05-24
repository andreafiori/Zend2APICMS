<?php

namespace Admin\Model\Users;

use Admin\Model\ControllerHelperAbstract;
use Admin\Model\Users\Roles\UsersRolesGetterWrapper;
use Admin\Model\Users\Settori\UsersSettoriGetterWrapper;
use Application\Model\NullException;

class UsersControllerHelper extends ControllerHelperAbstract
{
    /**
     * @var UsersSettoriGetterWrapper
     */
    private $usersSettoriGetterWrapper;

    private $usersSettoriGetterWrapperRecords;

    /**
     * @var UsersRolesGetterWrapper
     */
    private $usersRolesGetterWrapper;

    private $usersRolesGetterWrapperRecords;

    /**
     * @return UsersSettoriGetterWrapper
     */
    public function getUsersSettoriGetterWrapper()
    {
        return $this->usersSettoriGetterWrapper;
    }

    /**
     * @param UsersSettoriGetterWrapper $usersSettoriGetterWrapper
     */
    public function setUsersSettoriGetterWrapper(UsersSettoriGetterWrapper $usersSettoriGetterWrapper)
    {
        $this->usersSettoriGetterWrapper = $usersSettoriGetterWrapper;
    }

    /**
     * @return array
     */
    public function getUsersSettoriGetterWrapperRecords()
    {
        return $this->usersSettoriGetterWrapperRecords;
    }


    /**
     * @param UsersRolesGetterWrapper $usersRolesGetterWrapper
     */
    public function setUsersRolesGetterWrapper(UsersRolesGetterWrapper $usersRolesGetterWrapper)
    {
        $this->usersRolesGetterWrapper = $usersRolesGetterWrapper;
    }

    /**
     * @return UsersRolesGetterWrapper
     */
    public function getUsersRolesGetterWrapper()
    {
        return $this->usersRolesGetterWrapper;
    }

    /**
     * @param array $input
     */
    public function setupUsersRolesGetterWrapperRecords($input = array())
    {
        $this->assetUsersRolesGetterWrapper();

        $this->usersRolesGetterWrapperRecords = $this->recoverWrapperRecords(
            $this->getUsersRolesGetterWrapper(),
            $input
        );
    }

    /**
     * @return mixed
     */
    public function getUsersRolesGetterWrapperRecords()
    {
        return $this->usersRolesGetterWrapperRecords;
    }

    public function formatUsersRolesGetterWrapperRecordsForDropdown($records = array())
    {
        $this->assertUsersRolesGetterWrapperRecords();

        $roles = (empty($records)) ? $this->getUsersSettoriGetterWrapperRecords() : $records;

        $rolesList = array();
        foreach($roles as $role) {
            $settoriList[$role['id']] = $role['name'];
        }

        $this->usersRolesGetterWrapperRecords = $rolesList;
    }

    private function assertUsersRolesGetterWrapperRecords()
    {
        if (!$this->getUsersRolesGetterWrapperRecords()) {
            throw new NullException("UsersRolesGetterWrapperRecords are not set");
        }
    }

    /**
     * @param array $input
     */
    public function setupUsersSettoriGetterWrapperRecords($input = array())
    {
        $this->assertUsersSettoriGetterWrapper();

        $this->usersSettoriGetterWrapperRecords = $this->recoverWrapperRecords(
            $this->getUsersSettoriGetterWrapper(),
            $input
        );
    }

    /**
     * @param array $records
     */
    public function formatUsersSettoriGetterWrapperRecordsForDropdown($records = array())
    {
        $this->assertUsersSettoriGetterWrapperRecords();

        $settori = (empty($records)) ? $this->getUsersSettoriGetterWrapperRecords() : $records;

        $settoriList = array();
        foreach($settori as $settore) {
            $settoriList[$settore['id']] = $settore['nome'];
        }

        $this->usersSettoriGetterWrapperRecords = $settoriList;
    }

    /**
     * @throws NullException
     */
    private function assertUsersSettoriGetterWrapper()
    {
        if (!$this->getUsersSettoriGetterWrapper()) {
            throw new NullException("UsersSettoriGetterWrapper is not set");
        }
    }

    private function assetUsersRolesGetterWrapper()
    {
        if (!$this->getUsersRolesGetterWrapper()) {
            throw new NullException("UsersRolesGetterWrapper is not set");
        }
    }

    /**
     * @throws NullException
     */
    private function assertUsersSettoriGetterWrapperRecords()
    {
        if (!$this->getUsersSettoriGetterWrapperRecords()) {
            throw new NullException("UsersSettoriGetterWrapperRecords are not set");
        }
    }
}