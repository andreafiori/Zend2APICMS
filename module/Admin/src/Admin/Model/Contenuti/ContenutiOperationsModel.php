<?php

namespace Admin\Model\Contenuti;

use Admin\Model\OperationsModelAbstract;
use Application\Model\Database\DbTableContainer;
use Application\Model\NullException;

class ContenutiOperationsModel extends OperationsModelAbstract
{
    private $contenutiGetterWrapper;

    private $contenutiRecords;

    public function insert($formData)
    {

    }

    public function update($formData)
    {

    }

    /**
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        $this->assertConnection();

        $this->getConnection()->delete(
            DbTableContainer::contenuti,
            array('id' => $id)
        );

        return true;
    }

    /**
     * @param mixed $contenutiGetterWrapper
     */
    public function setContenutiGetterWrapper($contenutiGetterWrapper)
    {
        $this->contenutiGetterWrapper = $contenutiGetterWrapper;
    }

    /**
     * @return mixed
     */
    public function getContenutiGetterWrapper()
    {
        return $this->contenutiGetterWrapper;
    }

    /**
     * @param array $input
     */
    public function setupContenutiRecords($input = array())
    {
        $this->assertContenutiGetterWrapper();

        $this->getContenutiGetterWrapper()->setInput($input);
        $this->getContenutiGetterWrapper()->setupQueryBuilder();

        $this->contenutiRecords = $this->getContenutiGetterWrapper()->getRecords();
    }

    private function assertContenutiGetterWrapper()
    {
        if (!$this->getContenutiGetterWrapper()) {
            throw new NullException("ContenutiGetterWrapper is not set");
        }
    }

    public function checkContenutiRecords()
    {
        $records = $this->getContenutiRecords();

        if ( empty($records) ) {
            throw new NullException("ContenutiRecords are empty or not set correctly");
        }
    }

    /**
     * @return mixed
     */
    public function getContenutiRecords()
    {
        return $this->contenutiRecords;
    }

    public function annull($id)
    {
        $this->assertConnection();

        $this->getConnection()->update(
            DbTableContainer::contenuti,
            array('attivo' => 0),
            array('id' => $id)
        );

        return true;
    }

    /**
     * @param $id
     * @return bool
     */
    public function updateAttivo($id, $value = 1)
    {
        $this->assertConnection();

        $this->getConnection()->update(
            DbTableContainer::contenuti,
            array('attivo' => $value),
            array('id' => $id)
        );

        return true;
    }
}