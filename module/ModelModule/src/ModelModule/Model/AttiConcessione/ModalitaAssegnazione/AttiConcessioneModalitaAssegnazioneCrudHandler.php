<?php

namespace ModelModule\Model\AttiConcessione\ModalitaAssegnazione;

use ModelModule\Model\FormData\CrudHandlerAbstract;
use ModelModule\Model\FormData\CrudHandlerInsertUpdateInterface;
use ModelModule\Model\FormData\CrudHandlerInterface;
use ModelModule\Model\Modules\ModulesContainer;
use ModelModule\Model\Database\DbTableContainer;
use Zend\InputFilter\InputFilterAwareInterface;

/**
 * @author Andrea Fiori
 * @since  30 March 2015
 */
class AttiConcessioneModalitaAssegnazioneCrudHandler extends CrudHandlerAbstract implements CrudHandlerInterface, CrudHandlerInsertUpdateInterface
{
    private $dbTable;

    private $moduleId;

    public function __construct()
    {
        $this->form = new AttiConcessioneModalitaAssegnazioneForm();

        $this->formInputFilter = new AttiConcessioneModalitaAssegnazioneFormInputFilter();

        $this->dbTable = DbTableContainer::attiConcessioneModAssegn;

        $this->moduleId = ModulesContainer::atti_concessione;
    }

    /**
     * @param InputFilterAwareInterface $formData
     *
     * @return array
     */
    public function validateFormData(InputFilterAwareInterface $formData)
    {
        $error = $this->checkValidateFormDataError(
            $formData,
            array('nome')
        );

        return $error;
    }

    /**
     * @param InputFilterAwareInterface $formData
     *
     * @return int
     */
    public function insert(InputFilterAwareInterface $formData)
    {
        $this->assertConnection();

        return $this->getConnection()->insert($this->dbTable, array(
            'nome' => $formData->nome,
        ));
    }

    /**
     * @param InputFilterAwareInterface $formData
     *
     * @return int
     */
    public function update(InputFilterAwareInterface $formData)
    {
        $this->assertConnection();

        $arrayToUpdate = array(
            'nome' => $formData->nome,
        );

        return $this->getConnection()->update(
            $this->dbTable,
            $arrayToUpdate,
            array('id'    => $formData->id),
            array('limit' => 1)
        );
    }

    /**
     * @param int $id
     */
    public function delete($id)
    {
        return $this->getConnection()->delete(
            $this->dbTable,
            array('id'    => $id),
            array('limit' => 1)
        );
    }

    /**
     * @return bool
     *
     * @throws \Application\Model\NullException
     */
    public function logInsertOk()
    {
        $this->assertUserDetails();

        $this->assertLogWriter();

        $userDetails = $this->getUserDetails();

        $LogWriter = $this->getLogWriter();

        $inputFilter = $this->getFormInputFilter();

        return $LogWriter->writeLog(array(
            'user_id'   => $userDetails->id,
            'module_id' => $this->moduleId,
            'message'   => "Inserita nuova modalita' assegnazione atto concessione ".$inputFilter->nome,
            'type'      => 'error',
            'backend'   => 1,
        ));
    }

    /**
     * @param null $message
     *
     * @return bool
     */
    public function logInsertKo($message = null)
    {
        $this->assertUserDetails();

        $this->assertLogWriter();

        $userDetails = $this->getUserDetails();

        $LogWriter = $this->getLogWriter();

        $inputFilter = $this->getFormInputFilter();

        return $LogWriter->writeLog(array(
            'user_id'   => $userDetails->id,
            'module_id' => $this->moduleId,
            'message'   => "Errore nell'inserimento della nuova modalita' assegnazione atto concessione atto concessione ".$inputFilter->nome.'Messaggio: '.$message,
            'type'      => 'error',
            'backend'   => 1,
        ));
    }

    /**
     * @return bool
     */
    public function logUpdateOk()
    {
        $this->assertUserDetails();

        $this->assertLogWriter();

        $userDetails = $this->getUserDetails();

        $LogWriter = $this->getLogWriter();

        $inputFilter = $this->getFormInputFilter();

        return $LogWriter->writeLog(array(
            'user_id'   => $userDetails->id,
            'module_id' => $this->moduleId,
            'message'   => "Aggiornata la modalita' assegnazione atto concessione ".$inputFilter->nome,
            'type'      => 'info',
            'backend'   => 1,
        ));
    }

    /**
     * @param null $message
     *
     * @return bool
     */
    public function logUpdateKo($message = null)
    {
        $this->assertUserDetails();

        $this->assertLogWriter();

        $userDetails = $this->getUserDetails();

        $LogWriter = $this->getLogWriter();

        $inputFilter = $this->getFormInputFilter();

        return $LogWriter->writeLog(array(
            'user_id'   => $userDetails->id,
            'module_id' => $this->moduleId,
            'message'   => "Errore nell'aggiornamento della modalita' assegnazione atto concessione ".$inputFilter->nome.' Messaggio: '.$message,
            'type'      => 'error',
            'backend'   => 1,
        ));
    }
}