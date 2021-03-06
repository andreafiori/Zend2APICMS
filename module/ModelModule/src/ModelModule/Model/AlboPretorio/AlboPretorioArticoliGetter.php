<?php

namespace ModelModule\Model\AlboPretorio;

use ModelModule\Model\QueryBuilderHelperAbstract;

class AlboPretorioArticoliGetter extends QueryBuilderHelperAbstract
{
    public function setMainQuery()
    {
        $this->setSelectQueryFields("DISTINCT(alboArticoli.id) AS id, alboArticoli.numeroProgressivo, alboArticoli.numeroAtto,
                alboArticoli.anno, alboArticoli.titolo,
                alboArticoli.dataPubblicare, alboArticoli.dataAttivazione, alboArticoli.dataRettifica,
                alboArticoli.oraAttivazione, alboArticoli.dataScadenza,
                alboArticoli.enteTerzo,
                alboArticoli.attivo,
                alboArticoli.checkRettifica,
                alboArticoli.note,
                IDENTITY(alboArticoli.sezione) AS sezione,
                alboArticoli.pubblicare,
                alboArticoli.annullato,
                alboArticoli.dataAnnullamento,
                alboArticoli.home, alboArticoli.fonteUrl,

                aps.id AS idSezione, aps.nome AS nomeSezione,

                u.id AS iduser, u.name AS userName, u.surname AS userSurname,
                settoreUtente.nome AS nomeSettore
        ");

        $this->getQueryBuilder()->select( $this->getSelectQueryFields() )
                                ->from('Application\Entity\ZfcmsComuniAlboArticoli', 'alboArticoli')
                                ->join('alboArticoli.sezione', 'aps')
                                ->join('alboArticoli.utente', 'u')
                                ->leftJoin('u.settore', 'settoreUtente')
                                ->where('alboArticoli.sezione = aps.id AND u.settore = settoreUtente.id ');
        
        return $this->getQueryBuilder();
    }
    
    /**
     * @param int|array $id
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function setId($id)
    {
        if ( is_numeric($id) ) {
            $this->getQueryBuilder()->andWhere('alboArticoli.id = :id ');
            $this->getQueryBuilder()->setParameter('id', $id);
        }
        
        if (is_array($id)) {
            $this->getQueryBuilder()->andWhere('alboArticoli.id IN ( :id ) ');
            $this->getQueryBuilder()->setParameter('id', $id);
        }
        
        return $this->getQueryBuilder();
    }
    
    /**
     * Set numero progressivo
     *
     * @param int $numeroProgressivo
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function setNumeroProgressivo($numeroProgressivo)
    {
        if ( is_numeric($numeroProgressivo) and $numeroProgressivo!=0 ) {
            $this->getQueryBuilder()->andWhere('alboArticoli.numeroProgressivo = :numeroProgressivo ');
            $this->getQueryBuilder()->setParameter('numeroProgressivo', $numeroProgressivo);
        }
        
        return $this->getQueryBuilder();
    }
    
    /**
     * Set numero atto
     *
     * @param int $numeroAtto
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function setNumeroAtto($numeroAtto)
    {
        if ( is_numeric($numeroAtto) ) {
            $this->getQueryBuilder()->andWhere('alboArticoli.numeroAtto = :numeroAtto ');
            $this->getQueryBuilder()->setParameter('numeroAtto', $numeroAtto);
        }
        
        return $this->getQueryBuilder();
    }
    
    /**
     * @param string $mese
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function setMese($mese)
    {
        if ( is_numeric($mese) ) {
            $this->getQueryBuilder()->andWhere('MONTH(alboArticoli.dataPubblicare) = :mese ');
            $this->getQueryBuilder()->setParameter('mese', $mese);
        }
        
        return $this->getQueryBuilder();
    }
    
    /**
     * Set anno
     *
     * @param int $anno
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function setAnno($anno)
    {
        if ( is_numeric($anno) and $anno != 0 ) {
            $this->getQueryBuilder()->andWhere('alboArticoli.anno = :anno ');
            $this->getQueryBuilder()->setParameter('anno', $anno);
        }
        
        return $this->getQueryBuilder();
    }
    
    /**
     * Set data scadenza
     *
     * @param \DateTime|string $dataScadenza
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function setDataScadenza($dataScadenza)
    {
        if ($dataScadenza) {
            $this->getQueryBuilder()->andWhere('alboArticoli.dataScadenza = :dataScadenza ');
            $this->getQueryBuilder()->setParameter('dataScadenza', $dataScadenza);
        }
        
        return $this->getQueryBuilder();
    }
    
    /**
     * Set sezione ID
     *
     * @param int $id
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function setSezioneId($id)
    {
        if ( is_numeric($id) ) {
            $this->getQueryBuilder()->andWhere('alboArticoli.sezione = :sezioneId ');
            $this->getQueryBuilder()->setParameter('sezioneId', $id);
        }
        
        return $this->getQueryBuilder();
    }
    
    /**
     * Set user ID
     *
     * @param int $id
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function setUtenteId($id)
    {
        if ( is_numeric($id) ) {
            $this->getQueryBuilder()->andWhere('alboArticoli.utente = :utenteId ');
            $this->getQueryBuilder()->setParameter('utenteId', $id);
        }
        
        return $this->getQueryBuilder();
    }
    
    /**
     * @param int $annulled
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function setAnnullato($annulled)
    {
        if ( is_numeric($annulled) ) {
            $this->getQueryBuilder()->andWhere('alboArticoli.annullato = :annullato ');
            $this->getQueryBuilder()->setParameter('annullato', $annulled);
        }

        return $this->getQueryBuilder();
    }
    
    /**
     * @param int $pubblicare
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function setPubblicare($pubblicare)
    {
        if ( is_numeric($pubblicare) ) {
            $this->getQueryBuilder()->andWhere('alboArticoli.pubblicare = :pubblicare ');
            $this->getQueryBuilder()->setParameter('pubblicare', $pubblicare);
        }
        
        return $this->getQueryBuilder();
    }
    
    /**
     * @param int $attivo
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function setAttivo($attivo)
    {
        if ( is_numeric($attivo) ) {
            $this->getQueryBuilder()->andWhere('alboArticoli.attivo = :attivo ');
            $this->getQueryBuilder()->setParameter('attivo', $attivo);
        }
        
        return $this->getQueryBuilder();
    }

    /**
     * @param int $noScaduti
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function setNoScaduti($noScaduti)
    {
        if ($noScaduti == 1) {
            $this->getQueryBuilder()->andWhere("( alboArticoli.dataScadenza > '".date("Y-m-d H:i:s")."'
            OR alboArticoli.dataScadenza = '0000-00-00 00:00:00') ");
        }

        return $this->getQueryBuilder();
    }

    /**
     * Set text search
     *
     * @param string $search
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function setFreeSearch($search)
    {
        if (!empty($search)) {
            $search = strtolower($search);

            $this->getQueryBuilder()->andWhere(' ( LOWER(alboArticoli.titolo) LIKE :freeSearch OR LOWER(aps.nome) LIKE :freeSearch ) ');
            $this->getQueryBuilder()->setParameter('freeSearch', "%$search%");
        }

        return $this->getQueryBuilder();
    }

    /**
     * @param int $inHome
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function setHome($inHome)
    {
        if ($inHome == 1) {
            $this->getQueryBuilder()->andWhere("alboArticoli.home = 1 ");
        }

        return $this->getQueryBuilder();
    }
}
