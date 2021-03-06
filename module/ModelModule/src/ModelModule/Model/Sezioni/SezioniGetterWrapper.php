<?php

namespace ModelModule\Model\Sezioni;

use ModelModule\Model\RecordsGetterWrapperAbstract;

class SezioniGetterWrapper extends RecordsGetterWrapperAbstract
{
    /**
     *@var SezioniGetter
     */
    protected $objectGetter;

    /**
     * @param SezioniGetter $objectGetter
     */
    public function __construct(SezioniGetter $objectGetter)
    {
        $this->setObjectGetter($objectGetter);
    }
    
    public function setupQueryBuilder()
    {
        $this->objectGetter->setSelectQueryFields( $this->getInput('fields', 1) );

        $this->objectGetter->setMainQuery();

        $this->objectGetter->setId( $this->getInput('id', 1) );
        $this->objectGetter->setExcludeId( $this->getInput('excludeId', 1) );
        $this->objectGetter->setColonna( $this->getInput('colonna', 1) );
        $this->objectGetter->setAttivo( $this->getInput('attivo', 1) );
        $this->objectGetter->setModuloId( $this->getInput('moduloId', 1) );
        $this->objectGetter->setSlug( $this->getInput('slug', 1) );
        $this->objectGetter->setBlocco( $this->getInput('blocco', 1) );
        $this->objectGetter->setLingua( $this->getInput('lingua', 1) );
        $this->objectGetter->setLanguageAbbreviation( $this->getInput('languageAbbreviation', 1) );
        $this->objectGetter->setIsAmmTrasparente( $this->getInput('isAmmTrasparente', 1) );
        $this->objectGetter->setOrderBy( $this->getInput('orderBy', 1) );
        $this->objectGetter->setLimit( $this->getInput('limit', 1) );
    }

    /**
     * @param array $records
     * @param array $inputToMerge
     * @return array
     */
    public function addSottoSezioni($records, $inputToMerge = array())
    {
        if (!empty($records)) {

            foreach($records as &$record) {
                $wrapper = new SottoSezioniGetterWrapper(
                    new SottoSezioniGetter($this->objectGetter->getEntityManager())
                );
                $wrapper->setInput( array_merge( array(
                        'sezioneId' => isset($record['id']) ? $record['id'] : null,
                        'orderBy'   => 'sottosezioni.posizione',
                        'isSs'      => 0
                    ),
                    $inputToMerge
                ));
                $wrapper->setupQueryBuilder();

                $record['sottosezioni'] = is_array($wrapper->getRecords()) ? $wrapper->getRecords() : null;
            }

            return $records;
        }
    }

    /**
     * @param array $records
     * @return array
     */
    public function formatRecordsPerColumn($records)
    {
        if (!empty($records)) {
            $toReturn = array();
            foreach($records as $record) {
                if (isset($record['colonna'])) {
                    $toReturn[$record['colonna']][] = $record;
                }
            }

            return $toReturn;
        }

        return null;
    }
}
