<?php

namespace Admin\Controller\Users\Roles;

use Admin\Model\Users\Roles\UsersRolesForm;
use Admin\Model\Users\Roles\UsersRolesGetter;
use Admin\Model\Users\Roles\UsersRolesGetterWrapper;
use Admin\Model\Users\Roles\UsersRolesPermissionsGetter;
use Admin\Model\Users\Roles\UsersRolesPermissionsGetterWrapper;
use Admin\Model\Users\Roles\UsersRolesPermissionsRelationsGetter;
use Admin\Model\Users\Roles\UsersRolesPermissionsRelationsGetterWrapper;
use Application\Controller\SetupAbstractController;
use Zend\Permissions\Acl\Acl;

class UsersRolesFormController extends SetupAbstractController
{
    public function indexAction()
    {
        $mainLayout = $this->initializeAdminArea();

        $id = $this->params()->fromRoute('id');

        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

        if (is_numeric($id)) {
            $wrapper = new UsersRolesGetterWrapper(new UsersRolesGetter($em) );
            $wrapper->setInput( array('id' => $id, 'limit' => 1) );
            $wrapper->setupQueryBuilder();

            $roleRecord = $wrapper->getRecords();
        }

        $permissionsWrapper = new UsersRolesPermissionsGetterWrapper( new UsersRolesPermissionsGetter($em) );
        $permissionsWrapper->setInput( array() );
        $permissionsWrapper->setupQueryBuilder();

        $permissionsRecords = $permissionsWrapper->getRecords();

        $acl = new Acl();

        $form = new UsersRolesForm();

        if ( !empty($roleRecord) ) {

            /*if ($roleRecord[0]['name'] === 'WebMaster') {
                return $this->redirect()->toRoute('admin', array('lang' => 'it'));
            }*/

            $acl->addRole($roleRecord[0]['name']);

            $permissionsCurrentRoles = new UsersRolesPermissionsRelationsGetterWrapper(
                new UsersRolesPermissionsRelationsGetter($em)
            );
            $permissionsCurrentRoles->setInput(array(
                'roleId'  => $roleRecord[0]['id'],
                'orderBy' => 'permission.position',
            ));
            $permissionsCurrentRoles->setupQueryBuilder();

            $permissionsCurrentRolesRecords = $permissionsCurrentRoles->getRecords();
            foreach($permissionsCurrentRolesRecords as $currentRolesRecord) {
                $acl->addResource($currentRolesRecord['flag']);
                $acl->allow($roleRecord[0]['name'], $currentRolesRecord['flag']);
            }

            $formAction      = 'users-roles/update/'.$roleRecord[0]['id'];
            $formTitle       = 'Modifica ruolo utente';
            $formDescription = 'Modifica dati relativi al ruolo';

            $form->setData($roleRecord[0]);
        } else {
            $formTitle       = 'Nuovo ruolo utente';
            $formDescription = 'Creazione nuovo ruolo utente.';
            $formAction      = 'users-roles/insert/';
        }

        $this->layout()->setVariables(array(
            'form'               => $form,
            'formAction'         => $formAction,
            'formTitle'          => $formTitle,
            'formDescription'    => $formDescription,
            'roleName'           => isset($roleRecord[0]['name']) ? $roleRecord[0]['name'] : null,
            'roleId'             => isset($roleRecord[0]['id']) ? $roleRecord[0]['id'] : null,
            'permissions'        => $permissionsWrapper->sortPerGroup($permissionsRecords),
            'acl'                => $acl,
            'formDataCommonPath' => 'backend/templates/common/',
            'adminAccess'        => isset($roleRecord[0]['adminAccess']) ? $roleRecord[0]['adminAccess'] : null,
            'templatePartial'    => 'users/roles-permissions-handler.phtml',
        ));

        $this->layout()->setTemplate($mainLayout);
    }

    /**
     * @param array|null $formPost
     * @return bool

    private function checkFormPost($formPost)
    {
    $crudHandler =  new UsersRolesPermissionsCrudHandler($this->getInput());
    $crudHandler->setConnection($this->getInput('entityManager')->getConnection());

    if (!empty($formPost['id'])) {

    $crudHandler->setOperation('update');

    $crudHandler->update();

    } else {

    $crudHandler->setOperation('insert');

    $crudHandler->insert();

    }
    }
     */
}