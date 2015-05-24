<?php

namespace AdminTest\Model\Users;

use Admin\Model\Users\Roles\UsersRolesGetter;
use Admin\Model\Users\Roles\UsersRolesGetterWrapper;
use Admin\Model\Users\Settori\UsersSettoriGetter;
use Admin\Model\Users\Settori\UsersSettoriGetterWrapper;
use Admin\Model\Users\UsersControllerHelper;
use Admin\Model\Users\UsersGetter;
use Admin\Model\Users\UsersGetterWrapper;
use ApplicationTest\TestSuite;

class UsersControllerHelperTest extends TestSuite
{
    /**
     * @var UsersControllerHelper
     */
    private $helper;

    protected function setUp()
    {
        parent::setUp();

        $this->helper = new UsersControllerHelper();
    }

    public function testSetUsersSettoriGetterWrapper()
    {
        $this->helper->setUsersSettoriGetterWrapper(
            new UsersSettoriGetterWrapper(new UsersSettoriGetter($this->getEntityManagerMock()))
        );

        $this->assertInstanceOf(
            '\Admin\Model\Users\Settori\UsersSettoriGetterWrapper',
            $this->helper->getUsersSettoriGetterWrapper()
        );
    }

    public function testSetRolesGetterWrapper()
    {
        $this->helper->setUsersRolesGetterWrapper(
            new UsersRolesGetterWrapper(new UsersRolesGetter($this->getEntityManagerMock()))
        );

        $this->assertInstanceOf(
            '\Admin\Model\Users\Roles\UsersRolesGetterWrapper',
            $this->helper->getUsersRolesGetterWrapper()
        );
    }

    public function testSetupUsersRolesGetterWrapperRecords()
    {
        $this->helper->setUsersRolesGetterWrapper(new UsersRolesGetterWrapper(
                new UsersRolesGetter($this->getEntityManagerMock()))
        );

        $this->helper->setupUsersRolesGetterWrapperRecords();

        $this->assertTrue( is_array($this->helper->getUsersRolesGetterWrapperRecords()) );
    }

    public function testSetupUsersSettoriGetterWrapperRecords()
    {
        $this->helper->setUsersSettoriGetterWrapper(new UsersSettoriGetterWrapper(
                new UsersSettoriGetter($this->getEntityManagerMock()))
        );

        $this->helper->setupUsersSettoriGetterWrapperRecords();

        $this->assertTrue( is_array($this->helper->getUsersSettoriGetterWrapperRecords()) );
    }

    public function testFormatUsersSettoriGetterWrapperRecordsForDropdown()
    {
        $this->helper->setUsersSettoriGetterWrapper(new UsersSettoriGetterWrapper(
                new UsersSettoriGetter($this->getEntityManagerMock()))
        );

        $this->helper->setupUsersSettoriGetterWrapperRecords();

        $this->helper->formatUsersSettoriGetterWrapperRecordsForDropdown(array(
            array(
                'id' => 1,
                'nome' => 'Settore 1'
            ),
            array(
                'id' => 2,
                'nome' => 'Settore 2'
            )
        ));

        $this->assertTrue( is_array($this->helper->getUsersSettoriGetterWrapperRecords()) );
    }

    public function testFormatUsersRolesGetterWrapperRecordsForDropdown()
    {
        $this->helper->setUsersRolesGetterWrapper(new UsersRolesGetterWrapper(
                new UsersRolesGetter($this->getEntityManagerMock()))
        );

        $this->helper->setupUsersRolesGetterWrapperRecords();

        $this->helper->formatUsersRolesGetterWrapperRecordsForDropdown(array(
            array(
                'id' => 1,
                'name' => 'WebMaster'
            ),
            array(
                'id' => 2,
                'name' => 'SuperAdmin'
            )
        ));

        $this->assertTrue( is_array($this->helper->getUsersRolesGetterWrapperRecords()) );
    }
}
